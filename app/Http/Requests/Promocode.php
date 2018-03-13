<?php

namespace Safeboda\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Promocode extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|unique:promocodes,code',
            'discount' => 'required',
            'active' => 'required',
            'expires_at' => 'date|nullable',
            'longitude' => 'double',
            'latitude' => 'double',
        ];
    }
}
