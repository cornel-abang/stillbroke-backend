<?php

namespace App\Http\Requests;

class SetFeatureTextRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "featured_txt" => "required|string|max:500",
        ];
    }
}
