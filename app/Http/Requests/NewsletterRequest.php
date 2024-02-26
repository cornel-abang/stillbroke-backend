<?php

namespace App\Http\Requests;

class NewsletterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|unique:newsletters",
        ];
    }

    public function messages()
    {
        return [
            "email.unique" => "You are already subscribed to our newsletter"
        ];
    }
}
