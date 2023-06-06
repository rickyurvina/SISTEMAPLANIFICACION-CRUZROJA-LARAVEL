<?php

namespace App\Http\Middleware\Azure;

use App\Jobs\Admin\AttachCompaniesToUser;
use App\Jobs\Admin\CreateRolesFromAzure;
use App\Models\Admin\Company;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Traits\Jobs;
use Auth;
use Closure;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class Azure
{
    use Jobs;

    protected string $login_route = "/login";

    protected string $baseUrl = "https://login.microsoftonline.com/";

    protected string $route2 = "/oauth2/v2.0/";

    protected string $route = "/oauth2/";

    public function handle($request, Closure $next)
    {
        $access_token = $request->session()->get('_azure_access_token');
        $refresh_token = $request->session()->get('_azure_refresh_token');

        if (config('app.env') === "testing") {
            return $this->handleTesting($request, $next, $access_token, $refresh_token);
        }

        if (!$access_token || !$refresh_token) {
            return $this->redirect($request);
        }

        $client = new Client();

        try {
            $form_params = [
                'grant_type' => 'refresh_token',
                'client_id' => config('azure.client.id'),
                'client_secret' => config('azure.client.secret'),
                'refresh_token' => $refresh_token,
                'resource' => config('azure.resource'),
            ];

            if (Route::has('azure.callback')) {
                $form_params['redirect_uri'] = route('azure.callback');
            }

            $response = $client->request('POST', $this->baseUrl . config('azure.tenant_id') . $this->route . "token", [
                'form_params' => $form_params,
            ]);

            $contents = json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            $this->fail($request, $e);
        }

        if (empty($contents->access_token) || empty($contents->refresh_token)) {
            $this->fail($request, new Exception('Missing tokens in response contents'));
        }

        $request->session()->put('_azure_access_token', $contents->access_token);
        $request->session()->put('_azure_refresh_token', $contents->refresh_token);

        return $this->handleCallback($request, $next, $access_token, $refresh_token);
    }

    /**
     * Handle an incoming request in a testing environment
     * Assumes tester is calling actingAs or loginAs during testing to run this correctly
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return RedirectResponse|Redirector|mixed
     */
    protected function handleTesting(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (!isset($user)) {
            return $this->redirect($request, $next);
        }

        return $this->handleCallback($request, $next, null, null);
    }

    /**
     * Gets the azure url
     *
     * @return String
     */
    public function getAzureUrl(): string
    {
        $url = $this->baseUrl . config('azure.tenant_id') . $this->route2 . "authorize?response_type=code&client_id=" . config('azure.client.id') . "&domain_hint=" . urlencode(config('azure.domain_hint')) . "&scope=" . urldecode(config('azure.scope'));

        return Route::has('azure.callback') ? $url . '&redirect_uri=' . urlencode(route('azure.callback')) : $url;
    }

    /**
     * Redirects to the Azure route.  Typically used to point a web route to this method.
     * For example: Route::get('/login/azure', 'App\Http\Middleware\Azure@azure');
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function azure(Request $request): RedirectResponse
    {
        return redirect()->away($this->getAzureUrl());
    }

    /**
     * Customized Redirect method
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector|mixed
     */
    protected function redirect(Request $request)
    {
        return redirect()->guest($this->login_route);
    }

    /**
     * Callback after login from Azure
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector|mixed
     * @throws GuzzleException
     */
    public function azureCallback(Request $request): mixed
    {
        $client = new Client();

        $code = $request->input('code');

        try {
            $response = $client->request('POST', $this->baseUrl . config('azure.tenant_id') . $this->route . "token", [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => config('azure.client.id'),
                    'client_secret' => config('azure.client.secret'),
                    'code' => $code,
                    'resource' => config('azure.resource'),
                    'redirect_uri' => route('azure.callback')
                ]
            ]);

            $contents = json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $this->fail($request, $e);
        }

        $access_token = $contents->access_token;
        $refresh_token = $contents->refresh_token;
        $profile = json_decode(base64_decode(explode(".", $contents->id_token)[1]));

        $request->session()->put('_azure_access_token', $access_token);
        $request->session()->put('_azure_refresh_token', $refresh_token);

        $data =
            [
                'name' => $profile->name,
                'email' => $profile->email,
                'ipaddr' => $profile->ipaddr,
                'roles' => $profile->roles,
            ];
        $request->session()->put('data_azure', json_encode($data));

        return view('auth.app', compact('data'));

    }

    /**
     * Handler that is called when a successful login has taken place for the first time
     *
     * @param Request $request
     * @param String $access_token
     * @param String $refresh_token
     * @param mixed $profile
     *
     * @return RedirectResponse
     */
    public function success(Request $request, $access_token, $refresh_token, $profile)
    {
        try {
            $email = strtolower($profile->email);
            $name = $profile->name ? $profile->name : $profile->getDisplayName();

            $user = User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'email' => $email,
                'password' => 'password',
                'locale' => 'es_ES',
                'enabled' => true,
                'last_logged_in_at' => now(),
                'last_ip_connected' => $profile->ipaddr,
                'remember_token' => $access_token,
            ]);

            Auth::login($user);

            if (!auth()->check()) {
                return redirect()->route('login/azure');
            }

            $user = user();
            $companies = [];
            $rolesFromProfile = [];
            if (is_array($profile->roles)) {
                $resultSplitRolesCompanies = self::splitRolesCompanies($profile->roles);
                $companies = $resultSplitRolesCompanies[0];
                $rolesFromProfile = $resultSplitRolesCompanies[1];
            }

            if ($companies) {
                $this->ajaxDispatch(new AttachCompaniesToUser($companies));
            } else {
                $user->companies()->detach();
            }

            // Get first company
            $company = $user->companies()->enabled()->first();

            // Logout if no company assigned
            if (!$company) {
                $this->azureLogout($request);
            }

            // Check if user is enabled
            if (!$user->enabled) {
                $this->azureLogout($request);
            }

            $this->ajaxDispatch(new CreateRolesFromAzure($rolesFromProfile));

            $userRoles = $profile->roles ?? [];
            $roles = [];
            $role = new Role;

            foreach ($userRoles as $uRol) {
                $name = $role->transformNameRol($uRol);
                $rolInPlanning = Role::where('name', $name)->first();
                if (!is_null($rolInPlanning)) {
                    $element = [];
                    $element['role_id'] = $rolInPlanning->id;
                    array_push($roles, $element);
                }
            }

            if (count($roles) > 0) {
                $roles = array_reduce($roles, function ($result, $item) {
                    $name = $item['role_id'];
                    if (!isset($result[$name])) {
                        $result[$name] = $item;
                    }
                    return $result;
                }, []);
                $user->roles()->syncWithoutDetaching($roles);
            }
        } catch (Exception $exception) {
            flash($exception->getMessage())->error();
        }
        return redirect()->intended(route('common.home'));
    }

    /**
     * @param $roles
     * @return void
     */
    protected function splitRolesCompanies($roles)
    {
        $companies = [];
        $roles2 = [];
        foreach ($roles as $index => $role) {
            $name = strtolower($role);
            $name = trim($name);
            $arrayName = explode("_", $name);
            if (is_array($arrayName)) {
                if ($arrayName[0] == 'junta') {
                    array_push($companies, $name);
                } else {
                    array_push($roles2, $name);
                }
            }
        }

        return [$companies, $roles2];
    }

    /**
     * Handler that is called when a failed handshake has taken place
     *
     * @param Request $request
     * @param Exception $e
     *
     * @return string
     */
    protected function fail(Request $request, Exception $e)
    {
        // JustinByrne updated the original code from smitthhyy (18 Dec 2019) to change to an array to allow for multiple error codes.
        if ($request->isMethod('get')) {
            $errorDescription = trim(substr($request->query('error_description', 'SOMETHING_ELSE'), 0, 11));

            $azureErrors = [
                'AADSTS50105' => [
                    'HTTP_CODE' => '403',
                    'msg' => 'User is not authorized within Azure AD to access this application.',
                ],
                'AADSTS90072' => [
                    'HTTP_CODE' => '403',
                    'msg' => 'The logged on User is not in the allowed Tenant. Log in with a User in the allowed Tenant.',
                ],
            ];

            if (array_key_exists($errorDescription, $azureErrors)) {
                return abort($azureErrors[$errorDescription]['HTTP_CODE'], $azureErrors[$errorDescription]['msg']);
            }
        }

        return implode("", explode(PHP_EOL, $e->getMessage()));
    }

    /**
     * Handler that is called every request when a user is logged in
     *
     * @param Request $request
     * @param Closure $next
     * @param String $access_token
     * @param String $refresh_token
     *
     * @return RedirectResponse|Redirector|mixed
     */
    protected function handleCallback(Request $request, Closure $next, $access_token, $refresh_token): mixed
    {
        return $next($request);
    }

    /**
     * Gets the logout url
     *
     * @return String
     */
    public function getLogoutUrl()
    {
        return $this->baseUrl . "common" . $this->route . "logout?post_logout_redirect_uri=" . config('azure.redirect_logout');
    }

    /**
     * Redirects to the Azure logout route.  Typically used to point a web route to this method.
     * For example: Route::get('/logout/azure', 'App\Http\Middleware\Azure@azurelogout');
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function azureLogout(Request $request)
    {
        // Session destroy is required if stored in database
        if (config('session.driver') === 'database') {
            $request->session()->getHandler()->destroy($request->session()->getId());
        }

        $request->session()->pull('_azure_access_token');
        $request->session()->pull('_azure_refresh_token');

        auth()->logout();

        return redirect()->away($this->getLogoutUrl());
    }

    public function azureLogoutCallback(Request $request)
    {
        Log::info('MS Logout', $request->all());
    }
}
