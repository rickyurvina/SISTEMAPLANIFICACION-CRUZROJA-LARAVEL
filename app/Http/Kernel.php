<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            'cookies.encrypt',
            'cookies.response',
            'session.start',
            'session.errors',
            'csrf',
            'bindings',
            'company.settings',
        ],

        'common' => [
            'web',
            'auth',
            'auth.disabled',
        ],

        'guest' => [
            'web',
            'auth.redirect',
        ],

        'admin' => [
            'common',
            'menu.admin'
        ],

        'strategy' => [
            'common',
            'menu.strategy'
        ],

        'project' => [
            'common',
            'menu.project'
        ],

        'budget' => [
            'common',
            'menu.budget'
        ],

        'process' => [
            'common',
            'menu.process'
        ],

        'risk' => [
            'common',
            'menu.risk'
        ],

        'indicator' => [
            'common',
            'menu.indicator'
        ],

        'audit' => [
            'common',
            'menu.audit'
        ],

        'poa' => [
            'common',
            'menu.poa'
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Laravel
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'cookies.encrypt' => \App\Http\Middleware\EncryptCookies::class,
        'cookies.response' => \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        'session.auth' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'session.errors' => \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        'session.start' => \Illuminate\Session\Middleware\StartSession::class,

        // Laverix
        'auth.disabled' => \App\Http\Middleware\LogoutIfUserDisabled::class,
        'auth.redirect' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'menu.admin' => \App\Http\Middleware\AdminMenu::class,
        'menu.strategy' => \App\Http\Middleware\StrategyMenu::class,
        'menu.project' => \App\Http\Middleware\ProjectMenu::class,
        'menu.budget' => \App\Http\Middleware\BudgetMenu::class,
        'menu.process' => \App\Http\Middleware\ProcessMenu::class,
        'menu.risk' => \App\Http\Middleware\RiskMenu::class,
        'menu.indicator' => \App\Http\Middleware\IndicatorMenu::class,
        'menu.audit' => \App\Http\Middleware\AuditMenu::class,
        'menu.common' => \App\Http\Middleware\CommonMenu::class,
        'menu.poa' => \App\Http\Middleware\PoaMenu::class,
        'company.settings' => \App\Http\Middleware\LoadSettings::class,

        // Spatie
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,

        //Azure AD
        // 'azure' => \RootInc\LaravelAzureMiddleware\Azure::class,
        'azure' => \App\Http\Middleware\AppAzure::class

    ];
}
