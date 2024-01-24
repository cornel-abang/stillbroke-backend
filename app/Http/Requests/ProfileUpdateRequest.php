<?php

namespace App\Http\Requests;

class ProfileUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "email",
            "first_name" => "string",
            "last_name" => "string",
        ];
    }
}
