<?php

namespace App\Http\Middleware;

use App\Events\Menu\BudgetCreated;
use Closure;
use Illuminate\Http\Request;
use Lavary\Menu\Menu;

class BudgetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if logged in
        if (!auth()->check()) {
            return $next($request);
        }

        $menu = (new Menu)->make('Menu', function () {});
        event(new BudgetCreated($menu));

        return $next($request);
    }
}
