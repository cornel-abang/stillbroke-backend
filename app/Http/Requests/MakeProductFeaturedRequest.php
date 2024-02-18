<?php

namespace App\Http\Requests;

class MakeProductFeaturedRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['feature_text' => 'required|text'];
    }
}
