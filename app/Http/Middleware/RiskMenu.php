<?php

namespace App\Http\Middleware;

use App\Events\Menu\RiskCreated;
use Closure;
use Illuminate\Http\Request;
use Lavary\Menu\Menu;

class RiskMenu
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $menu = (new Menu)->make('Menu', function () {
        });
        event(new RiskCreated($menu));

        return $next($request);
    }
}
