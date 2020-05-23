<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminAuthCheck
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect(route('admin.login'));
        }
        
        return $next($request);
    }
}
