<?php

namespace App\Http\Requests;

class AddProductCatRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'image' => 'required|image'
        ];
    }
}
