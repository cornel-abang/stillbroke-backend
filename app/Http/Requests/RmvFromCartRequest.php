<?php

namespace App\Http\Requests;

class RmvFromCartRequest extends BaseRequest
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
        ];
    }
}
