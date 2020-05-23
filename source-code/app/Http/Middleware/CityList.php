<?php

namespace App\Http\Middleware;

use View;
use Auth;
use Cache;
use Cookie;
use Closure;
use App\Models\City;
use App\Models\Page;

class CityList
{
    public $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function handle($request, Closure $next)
    {
        $countryId = config('settings.site_country');
        $cities = Cache::get('cities_'.$countryId);
        if(empty($cities) === true){
            $cities = $this->city->getCities($countryId);
            Cache::forever('cities_'.$countryId, $cities);
        }
        
        View::share('cityLists', $cities);
        $city = Cookie::get('city');
        if(empty($city) === true){
            $city = config('settings.default_city');
        }        

        View::share('selected_city', $city);

        $pages = Page::select('title','slug')->get()->toArray();
        View::share('page_lists', $pages);

        return $next($request);
    }
}
