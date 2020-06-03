<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'birthday' => 'date_format:Y-M-D',
            'school' => 'string',
            'phone' => 'numeric',
            'address' => 'string|max:60',
            'avatar' => 'string',
            'class' => 'string'
        ];
    }
}
