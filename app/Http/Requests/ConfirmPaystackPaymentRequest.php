<?php

namespace App\Http\Requests;

class ConfirmPaystackPaymentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "tx_ref" => "required|string",
            "user_id" => "required|string",
            "cart_token" => "required|string",
            "shipping_address" => "required|string",
            "shipping_phone" => "required|string",
            "amount" => "required|integer",
        ];
    }
}
