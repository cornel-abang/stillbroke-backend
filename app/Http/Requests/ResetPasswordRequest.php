<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "old_password" => "required|string",
            "password" => "required|string|min:5|confirmed",
        ];
    }
}
