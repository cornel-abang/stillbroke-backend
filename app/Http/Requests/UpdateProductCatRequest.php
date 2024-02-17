<?php

namespace App\Http\Requests;

class UpdateProductCatRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required_without_all:image|string',
            'image' => 'required_without_all:name|string'
        ];
    }

    public function messages(): array
    {
        return [
            'required_without_all' => 'One of the fields: name, image..., must be present'
        ];
    }
}
