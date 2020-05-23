<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AddWithdraw extends FormRequest
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
        $min = config('site.minimum_withdrawal_amount');
        $type = $request->get('payment_method');

        $rule = [];
        $rule['amount'] = 'required|numeric|min:'.$min;
        $rule['paypal_email'] = 'required|email';

        return $rule;
    }
}
