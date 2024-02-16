<?php

namespace App\Http\Requests;

class AddProdDiscountRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'percentage' => 'required|integer',
            'duration' => 'required|integer'
        ];
    }
}
