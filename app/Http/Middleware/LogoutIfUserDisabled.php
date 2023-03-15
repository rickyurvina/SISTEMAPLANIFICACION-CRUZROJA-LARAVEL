<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogoutIfUserDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = user();

        if (!$user || $user->enabled) {
            return $next($request);
        }

        auth()->logout();

        return redirect()->route('login');
    }
}
