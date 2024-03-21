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
            'title' => 'required_without_all:price,category_id,description,gender,primary_image,avail_qty|string',
            'price' => 'required_without_all:title,category_id,description,gender,primary_image,avail_qty|integer',
            'category_id' => 'required_without_all:price,title,description,gender,primary_image,avail_qty|integer|exists:categories,id',
            'description' => 'required_without_all:price,category_id,title,gender,primary_image,avail_qty|string',
            'gender' => 'required_without_all:price,category_id,description,title,primary_image,avail_qty|string|in:male,female,unisex',
            'primary_image' => 'required_without_all:price,category_id,description,gender,title,avail_qty|string',
            'avail_qty' => 'required_without_all:price,category_id,description,gender,title|integer',
            'other_images' => 'array',
            'extras' => 'array',
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
