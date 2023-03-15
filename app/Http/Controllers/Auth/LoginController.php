<?php

namespace App\Http\Controllers\Auth;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RootInc\LaravelAzureMiddleware\Azure;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * Show login form
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('auth.login.create');
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     *
     * @return RedirectResponse|Response
     */
    public function store(LoginRequest $request)
    {
        // Attempt to login
        if (!auth()->attempt($request->only('email', 'password'), $request->get('remember', false))) {
            return redirect()->route('login')
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    $this->username() => [trans('auth.failed')],
                ]);
        }

        // Get user object
        $user = user();

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

        return redirect()->intended(route('common.home'));
    }

    public function destroy()
    {
        $this->logout();

        return redirect()->route('login');
    }

    public function logout()
    {
        auth()->logout();

        // Session destroy is required if stored in database
        if (config('session.driver') == 'database') {
            $request = app('Illuminate\Http\Request');
            $request->session()->getHandler()->destroy($request->session()->getId());
        }
    }
}
