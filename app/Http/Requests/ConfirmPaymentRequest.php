<?php

namespace App\Http\Requests;

class ConfirmPaymentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "status" => "required|string",
            "tx_ref" => "required|string",
            "transaction_id" => "required|string",
        ];
    }
}
