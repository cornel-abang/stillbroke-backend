<?php

namespace App\Http\Requests;

class UpdateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required_without_all:last_name,email,password|string',
            'last_name' => 'required_without_all:first_name,email,password|string',
            'email' => 'required_without_all:last_name,first_name,password|email',
            'password' => 'required_without_all:last_name,email,first_name|string'
        ];
    }

    public function messages(): array
    {
        return [
            'required_without_all' => 'One of the fields: first_name, last_name, email, password..., must be present'
        ];
    }
}
