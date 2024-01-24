<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|unique:users",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "password" => "required|string|min:5|confirmed",
        ];
    }
}
