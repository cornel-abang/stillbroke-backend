<?php

namespace App\Http\Requests;

class UpdateProdDiscountRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'percentage' => 'required_without_all:duration',
            'duration' => 'required_without_all:percentage'
        ];
    }

    public function messages(): array
    {
        return [
            'required_without_all' => 'One of the fields: duration, percentage..., must be present'
        ];
    }
}
