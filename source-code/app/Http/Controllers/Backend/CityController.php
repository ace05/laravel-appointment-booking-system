<?php
namespace App\Http\Controllers\Backend;

use Cache;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends AdminBaseController
{
	public function getCities(Request $request, City $cityModel){	
       $cities = $cityModel->orderBy('created_at', 'desc')->paginate(20);
       return view('backend.cities.index', ['cities' => $cities]);
    }

    public function addCity(Request $request, Country $countryModel, City $cityModel)
    {
        $countries = $countryModel->pluck('country', 'id')->toArray();
        return view('backend.cities.add', ['countries' => $countries]);
    }

    public function add(Request $request, City $cityModel)
    {
        $this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'name' => 'required'
        ]);

        $city = $cityModel->create($request->except(['_token']));
        if(empty($city->id) === false){
            Cache::forget('cities_'.$city->country_id);
            return redirect()->route('admin.city.list')->with('success', __('message_city_add_success'));
        }

        return redirect()->route('admin.city.list')->with('error', __('message_city_add_failed'));
    }

    public function getCity($id, City $cityModel, Country $countryModel)
    {
    	$city = $cityModel->findOrFail($id);

        $countries = $countryModel->pluck('country', 'id')->toArray();

    	return view('backend.cities.edit', [
            'city' => $city, 'countries' => $countries
        ]);
    }

    public function updateCity($id, Request $request, City $cityModel)
    {
    	$this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'name' => 'required'
        ]);

    	$city = $cityModel->findOrFail($id);
        $country_id = $city->country_id;
    	$city->country_id = $request->get('country_id');
    	$city->name = $request->get('name');
    	if($city->save()){
            Cache::forget('cities_'.$country_id);
    		return redirect()->route('admin.city.list')->with('success', __('message_city_update_success'));
    	}

    	return redirect()->route('admin.city.list')->with('error', __('message_city_update_error'));
    }

    public function delete($id, Request $request, City $cityModel)
    {
        $city = $cityModel->findOrFail($id);
        $countryId = $city->country_id;
        if($city->delete()){
            Cache::forget('cities_'.$countryId);
            return redirect()->route('admin.city.list')->with('success', __('message_city_delete_success'));
        }

        return redirect()->route('admin.city.list')->with('success', __('message_city_delete_failed'));
    }

    public function enableCity($id, City $cityModel)
    {
        $city = $cityModel->where('is_active', '=', false)
                                ->find($id);
        if(empty($city->id) === true){
            return redirect()->route('admin.city.list')->with('error', __('message_city_already_active'));
        }

        $city->is_active = true;
        if($city->save()){
            Cache::forget('cities_'.$city->country_id);
            return redirect()->route('admin.city.list')->with('success', __('message_city_activate_success'));
        }

        return redirect()->route('admin.city.list')->with('error', __('message_city_activate_failed'));
    }

    public function disableCity($id, City $cityModel)
    {
        $city = $cityModel->where('is_active', '=', true)
                                ->find($id);
        if(empty($city->id) === true){
            return redirect()->route('admin.city.list')->with('error', __('message_city_already_inactive'));
        }

        $city->is_active = false;
        if($city->save()){
            Cache::forget('cities_'.$city->country_id);
            return redirect()->route('admin.city.list')->with('success', __('message_city_inactive_success'));
        }

        return redirect()->route('admin.city.list')->with('error', __('message_city_inactive_failed'));
    }
}