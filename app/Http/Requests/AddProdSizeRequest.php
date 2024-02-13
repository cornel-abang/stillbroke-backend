<?php

namespace App\Http\Requests;

class AddProdSizeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sizes' => 'required|array',
            'sizes.*' => 'required|string'
        ];
    }
}
