<?php

namespace App\Http\Requests;

class UpdateCartRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'string',
            'extra_id' => 'nullable|exists:extras,id',
            'cart_token' => 'required|string',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }
}
