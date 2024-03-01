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
            'category_id' => 'required|string|exists:categories,id',
            'description' => 'required|string',
            'gender' => 'required|string|in:male,female,unisex',
            'primary_image' => 'required|string',
            'avail_qty' => 'required|string',
            'other_images.*' => 'string',
            'colors.*' => 'required|string',
            'sizes.*' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'category_id.string' => 'The category ID is not a valid string',
            'category_id.exists' => 'The category with the given ID does not exist',
        ];
    }
}
