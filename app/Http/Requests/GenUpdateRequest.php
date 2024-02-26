<?php

namespace App\Http\Requests;

class GenUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "about" => "required_without_all:privacy,terms|string",
            "privacy" => "required_without_all:about,terms|string",
            "terms" => "required_without_all:about,privacy|string",
        ];
    }
}
