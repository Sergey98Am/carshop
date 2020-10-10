<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'quantity' => ['required','numeric'],
            'item_price' => ['required','numeric'],
            'status_id' => ['exists:statuses,id'],
            'car_id' => ['exists:cars,id'],
            'user_id' => ['exists:users,id'],
        ];
    }
}
