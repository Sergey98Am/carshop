<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
        return [
            'name' => ['required', 'regex:/^.*[A-Za-z].*/u'],
            'number' => ['required', 'regex:/^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/u'],
            'exp_month' => ['required', 'numeric','between:1,12'],
            'exp_year' => ['required', 'numeric', 'digits:4', 'min:'.(date('Y'))],
            'cvc' => ['required', 'numeric', 'digits:3'],
            'country' => ['required', 'regex:/^[\pL\s\-]+$/u'],
            'city' => ['required', 'regex:/^[\pL\s\-]+$/u'],
            'phone' => ['required', 'numeric'],
            'currency' => ['required', 'alpha'],
            'order_id' => ['exists:orders,id'],
            'user_id' => ['exists:users,id'],
        ];
    }
}
