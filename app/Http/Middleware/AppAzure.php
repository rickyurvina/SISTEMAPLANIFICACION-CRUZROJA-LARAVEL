<?php

namespace App\Http\Middleware;

use App\Models\Auth\Role;
use Illuminate\Http\Request;

use RootInc\LaravelAzureMiddleware\Azure as Azure;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

use Auth;

use App\Models\Auth\User;

class AppAzure extends Azure
{
    protected function success(Request $request, $access_token , $refresh_token,  $profile)
    {
        session(['azureToken' => $access_token]);
        $graph = new Graph();
        $graph->setApiVersion("v1.0")
            ->setAccessToken($access_token);

        $graph_user = $graph->createRequest("GET", "/me")
                        ->setReturnType(Model\User::class)
                        ->execute();

        $email = strtolower($graph_user->getMail());
        $surname = $graph_user->getSurname() ? $graph_user->getSurname() : $graph_user->getDisplayName();
        $name = $graph_user->getGivenName() ? $graph_user->getGivenName() : $graph_user->getDisplayName();
        $businessPhone = $graph_user->getBusinessPhones();
        $userId = $graph_user->getId();

        $graphRol = new Graph();
        $graphRol->setApiVersion("v1.0")
                ->setAccessToken($access_token);

        $resourceId = config('azure.resource_id_p');

        $uri = '/users/' . $userId . "/appRoleAssignments?\$filter=resourceId eq " . $resourceId . "&\$select=appRoleId";

        $userRoles = $graphRol->createRequest("GET", $uri)
                    ->addHeaders(array("Content-Type" => "application/json"))
                    ->setReturnType(Model\AppRoleAssignment::class)
                    ->execute();
        $user = User::updateOrCreate(['email' => $email], [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => 'password',
            'locale' => 'es_ES',
            'enabled' => true,
            'contact_id' => 1,
            'job_title' => null,
            'business_phone' => empty($businessPhone) ? null : $businessPhone,
            'personal_phone' => null,
            'gender' => null,
            'date_birth' => null,
            'photo' => null,
            'personal_notes' => null,
            'employer_cost' => null,
            'competencies' => null,
            'working_skills' => null,
            'work_experience' => null,
            'contract_type' => null,
            'contract_start' => null,
            'contract_end' => null,
        ]);

        Auth::login($user);

        if (!auth()->check()) {
            return redirect()->route('login/azure');
        }

        $user = user();

        $user->companies()->Sync(1);

        // Get first company
        $company = $user->companies()->enabled()->first();

        // Logout if no company assigned
        if (!$company) {
            $this->logout();
            return redirect()->back()->withErrors(new MessageBag([$this->username() => trans('auth.error.no_company')]))->withInput($request->only('email', 'remember'));
        }

        // Check if user is enabled
        if (!$user->enabled) {
            $this->logout();

            return redirect()->back()->withErrors(new MessageBag([$this->username() => trans('auth.user_disabled')]))->withInput($request->only('email', 'remember'));
        }

        $roles = [];
        foreach($userRoles as $uRol) {
            $auxRol = Role::whereIdAzureadRol(strval($uRol->getAppRoleId()))->first();
            if(!is_null($auxRol) && !$user->hasRole($auxRol['id'])) {
                $element = [];
                $element['role_id'] = $auxRol['id'];
                array_push($roles, $element);
            }
        }

        if(count($roles) > 0) {
            $user->roles()->syncWithoutDetaching($roles);
        }

        return redirect()->intended(route('common.home'));
    }

    public function getLogoutUrl()
    {
        return $this->baseUrl . "common" . $this->route . "logout?post_logout_redirect_uri=". config('azure.redirect_logout');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function azurelogout(Request $request)
    {
        // Session destroy is required if stored in database
        if (config('session.driver') == 'database') {
            $request->session()->getHandler()->destroy($request->session()->getId());
        }

        $request->session()->pull('azureToken');
        $request->session()->pull('_rootinc_azure_access_token');
        $request->session()->pull('_rootinc_azure_refresh_token');

        auth()->logout();

        return redirect()->away($this->getLogoutUrl());
    }
}
