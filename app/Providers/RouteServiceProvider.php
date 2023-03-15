<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = 'common.home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapGuestRoutes();

        $this->mapCommonRoutes();

        $this->mapStrategyRoutes();

        $this->mapProjectRoutes();

        $this->mapBudgetRoutes();

        $this->mapAuditRoutes();

        $this->mapProcessRoutes();

        $this->mapIndicatorRoutes();

        $this->mapRiskRoutes();

        $this->mapPoaRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "guest" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapGuestRoutes()
    {
        Route::middleware('guest')
            ->namespace($this->namespace)
            ->group(base_path('routes/guest.php'));
    }

    /**
     * Define the "common" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapCommonRoutes()
    {
        Route::middleware('common')
            ->namespace($this->namespace)
            ->group(base_path('routes/common.php'));
    }

    /**
     * Define the "strategy" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapStrategyRoutes()
    {
        Route::middleware('strategy')
            ->namespace($this->namespace)
            ->group(base_path('routes/strategy.php'));
    }

    /**
     * Define the "project" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapProjectRoutes()
    {
        Route::middleware('project')
            ->namespace($this->namespace)
            ->group(base_path('routes/project.php'));
    }

    /**
     * Define the "budget" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapBudgetRoutes()
    {
        Route::middleware('budget')
            ->namespace($this->namespace)
            ->group(base_path('routes/budget.php'));
    }

    /**
     * Define the "audit" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAuditRoutes()
    {
        Route::middleware('audit')
            ->namespace($this->namespace)
            ->group(base_path('routes/audit.php'));
    }

    /**
     * Define the "process" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapProcessRoutes()
    {
        Route::middleware('process')
            ->namespace($this->namespace)
            ->group(base_path('routes/process.php'));
    }

    /**
     * Define the "indicator" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapIndicatorRoutes()
    {
        Route::middleware('indicator')
            ->namespace($this->namespace)
            ->group(base_path('routes/indicator.php'));
    }

    /**
     * Define the "risk" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapRiskRoutes()
    {
        Route::middleware('risk')
            ->namespace($this->namespace)
            ->group(base_path('routes/risk.php'));
    }

    /**
     * Define the "poa" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapPoaRoutes()
    {
        Route::middleware('poa')
            ->namespace($this->namespace)
            ->group(base_path('routes/poa.php'));
    }

}
