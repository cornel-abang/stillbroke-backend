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
            'item_index' => 'required|integer',
            'cart_token' => 'required|string',
            'qty' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return[
            'qty.required' => 'The quantity field is required',
            'qty.integer' => 'The quantity must be a number'
        ];
    }
}
