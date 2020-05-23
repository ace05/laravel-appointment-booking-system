<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class ServiceProviderRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $country = Country::find(config('settings.site_country'));
        return [
            'service_provider_name' => ['required'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => 'required|unique:users,mobile|phone:'.$country->iso.',mobile',
            'city_id' => 'required',
            'profession' => 'required',
            'about' => 'required',
            'password' => ['required', 'string', 'min:6']
        ];
    }
}
