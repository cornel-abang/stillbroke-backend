<?php

namespace App\Http\Requests;

class AddProdColorRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'colors' => 'required|array',
            'colors.*' => 'required|string'
        ];
    }
}
