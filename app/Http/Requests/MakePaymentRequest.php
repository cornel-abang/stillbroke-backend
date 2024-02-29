<?php

namespace App\Http\Requests;

class MakePaymentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "amount" => "required|integer",
            "user_id" => "required|integer|exists:users,id",
            "cart_token" => "required|string",
            "shipping_address" => "required|string",
            "shipping_phone" => "required|string",
        ];
    }
}
