<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterRequest extends FormRequest
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
            'first_name' => ['required','regex:/^[\pL\s\-]+$/u'],
            'last_name' => ['required','regex:/^[\pL\s\-]+$/u'],
            'email' => ['required','email','unique:users'],
            'date_of_birth' => ['required','date','date_format:Y-m-d','after:1909-12-31'],
            'gender' => ['required','alpha'],
            'country_id' => ['exists:countries,id'],
            'password' => ['required','string','min:8','confirmed'],
        ];
    }
}
