<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddPage extends FormRequest
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
        Validator::extend('details', function ($attribute, $value, $parameters, $validator) {
            $text = trim(strip_tags($value));
            return empty($text) === false;
        });

        return [
            'title' => 'required',
            'details' => 'required|details'
        ];
    }

    public function messages()
    {
        return [
            'details.details' => __('message_details_required')
        ];
    }
}
