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
            'title' => 'nullable|string',
            'price' => 'nullable|integer',
            'category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female,unisex',
            'primary_image' => 'nullable|string',
            'avail_qty' => 'nullable|integer',
            'other_images' => 'nullable|array',
            'extras' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'required_without_all' 
                => 'One of the fields: title, price, category_id, description, gender, primary_image, avail_qty..., must be present'
        ];
    }
}
