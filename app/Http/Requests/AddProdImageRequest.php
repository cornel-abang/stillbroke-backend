<?php

namespace App\Http\Requests;

class AddProdImageRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'other_images' => 'required|array',
            'other_images.*' => 'required|string'
        ];
    }
}
