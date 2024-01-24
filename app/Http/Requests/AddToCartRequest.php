<?php

namespace App\Http\Requests;

class AddToCartRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
            'cart_token' => 'required|string',
        ];
    }
}
