<?php
namespace App\Http\Controllers\Backend;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends AdminBaseController
{
	public function getCountries(Request $request, Country $countryModel){	
       $countries = $countryModel->paginate(20);
       return view('backend.countries.index', ['countries' => $countries]);
    }

    public function getCountry($id, Country $countryModel)
    {
    	$country = $countryModel->findOrFail($id);

    	return view('backend.countries.edit', ['country' => $country]);
    }

    public function updateCountry($id, Request $request, Country $countryModel)
    {
    	$this->validate($request, [
    		'iso' => 'required|unique:countries,iso,'.$id,
    		'iso3' => 'required',
    		'country' => 'required',
    		'currency_code' => 'required',
    		'currency_name' => 'required',
    		'phone_prefix' => 'required|numeric'
    	]);

    	$country = $countryModel->findOrFail($id);
    	$country->iso = $request->get('iso');
    	$country->iso3 = $request->get('iso3');
    	$country->country = $request->get('country');
    	$country->currency_code = $request->get('currency_code');
    	$country->currency_name = $request->get('currency_name');
    	$country->phone_prefix = $request->get('phone_prefix');
    	if($country->save()){
    		return redirect()->back()->with('success', __('message_country_update_success'));
    	}

    	return redirect()->back()->with('error', __('message_country_update_error'));
    }
}