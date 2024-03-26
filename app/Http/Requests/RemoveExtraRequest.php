<?php

namespace App\Http\Requests;

class RemoveExtraRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "extra_id" => "required|integer|exists:extras,id",
            "product_id" => "required|integer|exists:products,id",
            "cart_token" => "required|string",
        ];
    }
}
