<?php

namespace App\Http\Requests;

class PasswordUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:users",
            "password" => "required|string|min:5|confirmed",
        ];
    }
}
