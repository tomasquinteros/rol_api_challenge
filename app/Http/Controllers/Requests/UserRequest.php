<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.nullable' => 'The name field is optional and can be null.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
