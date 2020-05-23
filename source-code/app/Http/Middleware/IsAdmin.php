<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {
        $userType = Auth::user()->userType;
        if(empty($userType->is_admin) === true){
            return redirect('/'.config('app.locale'));
        }

        $adminLang = config('settings.admin_default_language');
        if(empty($adminLang) === false){
        	app()->setLocale($adminLang);
        }

        return $next($request);
    }
}
