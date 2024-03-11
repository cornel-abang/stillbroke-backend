<?php

namespace App\Http\Requests;

class SetCartTokenRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_token' => 'required|string',
        ];
    }
}
