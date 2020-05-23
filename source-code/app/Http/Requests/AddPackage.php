<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddPackage extends FormRequest
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
    public function rules(Request $request)
    {
        Validator::extend('details', function ($attribute, $value, $parameters, $validator) {
            $text = trim(strip_tags($value));
            return empty($text) === false;
        });

        Validator::extend('greater_than', function($attribute, $value, $params, $validator) use ($request){
            $other = $request->get($params[0]);
            return $value > $other;
        });

        $validation = [
            'name' => 'required',
            'details' => 'required|details',
            'price' => 'required|numeric|min:1',
            'city_id' => 'required',
            'service_sub_category_id' => 'required'
        ];

        $isEdit = $request->get('is_edit');
        if(empty($isEdit) === true){
            $validation['cover'] = 'required|image|dimensions:width=350,height=245';
        }

        if($request->hasFile('cover')){
            $validation['cover'] = 'image|dimensions:width=350,height=245';
        }

        $discount = $request->get('discount');
        if(empty($discount) === false){
            $validation['price'] = 'required|numeric|min:1|greater_than:discount';
            $validation['discount'] = 'numeric|min:1';
        }

        return $validation;
    }

    public function messages()
    {
        return [
            'price.greater_than' => __('message_price_greater_than_discount')
        ];
    }
}
