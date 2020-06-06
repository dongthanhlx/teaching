<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserDetailRequest extends FormRequest
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
            'birthday' => 'nullable|date_format:Y-M-D',
            'school' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:60',
            'avatar' => 'nullable|string',
            'class' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute field must be string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
