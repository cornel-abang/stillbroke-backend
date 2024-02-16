<?php

namespace App\Http\Requests;

class AddProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'required|string',
            'gender' => 'required|string|in:male,female,unisex',
            'primary_image' => 'required|image',
            'other_images.*' => 'image',
            'colors.*' => 'required|string',
            'sizes.*' => 'required|string',
        ];
    }
}