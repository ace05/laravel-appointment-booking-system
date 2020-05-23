<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $segment = $request->segment(1);
        $isAdmin = empty($segment) === false && $segment === 'admin' ? true : false;
        $defaultLocale = $isAdmin ? config('settings.admin_default_language') : config('settings.default_language');
        app()->setLocale($defaultLocale);

        return $next($request);
    }
}
