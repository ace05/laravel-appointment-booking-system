<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SmsTemplateUpdate extends FormRequest
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
        Validator::extend('template', function ($attribute, $value, $parameters, $validator) {
            $text = trim(strip_tags($value));
            return empty($text) === false;
        });

        return [
            'template' => 'required|template'
        ];
    }
}
