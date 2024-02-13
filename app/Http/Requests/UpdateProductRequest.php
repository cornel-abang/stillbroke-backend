<?php

namespace App\Http\Requests;

class UpdateProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string',
            'price' => 'integer',
            'category_id' => 'integer|exists:categories,id',
            'description' => 'string',
            'gender' => 'string|in:male,female,unisex',
            'primary_image' => 'image',
        ];
    }
}
