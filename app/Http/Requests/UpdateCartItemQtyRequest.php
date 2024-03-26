<?php

namespace App\Http\Requests;

class UpdateCartItemQtyRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'cart_token' => 'required|string',
            'qty' => 'nullable|integer'
        ];
    }

    public function messages(): array
    {
        return[
            'qty.integer' => 'The quantity must be a number'
        ];
    }
}
