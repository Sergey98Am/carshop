<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarUpdateRequest extends FormRequest
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
        $id = $this->request->get('id');
        return [
            'name' => 'required|min:2|max:255|unique:cars,name,'.$id,
            'price' => 'required',
            'condition' => 'required',
            'year' => 'required',
            'color' => 'required',
            'speed' => 'required',
            'category_id' => 'exists:categories,id',
            'brand_id' => 'exists:brands,id'
        ];
    }
}