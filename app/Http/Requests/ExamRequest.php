<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExamRequest extends FormRequest
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
            'header' => 'nullable|string',
            'description' => 'nullable|string',
            'class' => 'nullable|numeric',
            'time' => 'nullable|numeric',
            'note' => 'nullable|string',
            'rating' => 'nullable',
            'type' => 'nullable|string',
            'startTime' => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute field must be string',
            'numeric' => 'The :attribute field must be numeric'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
