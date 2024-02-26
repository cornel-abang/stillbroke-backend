<?php

namespace App\Http\Requests;

class ContactUsRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email",
            "name" => "required|string",
            "message" => "required|string|max:1000",
        ];
    }
}
