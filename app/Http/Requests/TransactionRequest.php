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
            'number' => 'required|numeric',
            'exp_month' => 'required|numeric|between:1,12',
            'exp_year' => 'required|numeric|digits:4|min:'.(date('Y')),
            'cvc' => 'required|numeric|digits:3',
            'country' => 'required|alpha',
            'city' => 'required|alpha',
            'phone' => 'required|numeric',
            'currency' => 'required|alpha',
            'order_id' => 'exists:orders,id',
            'user_id' => 'exists:users,id',
        ];
    }
}
