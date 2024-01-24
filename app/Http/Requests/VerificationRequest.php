<?php

namespace App\Http\Requests;

class VerificationRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email",
            "code" => "required|string",
            "user_id" => "required|integer",
        ];
    }
}
