<?php
namespace App\Http\Middleware;

use Cache;
use Closure;
use App\Models\Setting;

class Configuration
{

    public $settings;


    public function __construct(Setting $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $settings = Cache::get('settings');
        if(empty($settings) === true){
            $settings = $this->settings->getSettings();
            Cache::forever('settings', $settings);
        }
        
        if(empty($settings) === false){
            config($settings);
        }       

        return $next($request);
    }
}
