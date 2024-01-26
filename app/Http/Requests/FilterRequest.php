<?php

namespace App\Http\Requests;

class FilterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|in:gender',
            'filter' => 'required|string',
        ];
    }
}
