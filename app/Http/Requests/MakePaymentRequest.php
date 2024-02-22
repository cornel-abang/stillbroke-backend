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
            "stripeToken" => "required|string",
            "user_id" => "required|integer|exists:users,id",
            "cart_token" => "required|string"
        ];
    }
}