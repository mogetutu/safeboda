<?php

namespace Safeboda\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StorePromoCode extends FormRequest
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
            'code' => 'required|unique:promocodes,code',
            'discount' => 'required',
            'active' => 'required',
            'expires_at' => 'date|nullable',
            'longitude' => 'present',
            'latitude' => 'present',
        ];
    }

    /**
     * Custom failedValidation
     * @param  Validator $validator [description]
     * @return HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
