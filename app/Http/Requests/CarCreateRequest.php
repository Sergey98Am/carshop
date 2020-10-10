<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarCreateRequest extends FormRequest
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
            'name' => ['required','regex:/^.*[A-Za-z].*/u'],
            'price' => ['required','numeric'],
            'condition' => ['required','alpha'],
            'year' => ['required','numeric'],
            'color' => ['required','regex:/^[\pL\s\-]+$/u'],
            'speed' => ['required','numeric'],
            'shop_id' => ['exists:shops,id'],
            'category_id' => ['exists:categories,id'],
            'brand_id' => ['exists:brands,id'],
            'user_id' => ['exists:users,id'],
        ];
    }
}
