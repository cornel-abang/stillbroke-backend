<?php

namespace App\Http\Requests;

class UnSubNewsletterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:newsletters",
        ];
    }

    public function messages()
    {
        return [
            "email.exists" => "This email does not exist in our database"
        ];
    }
}
