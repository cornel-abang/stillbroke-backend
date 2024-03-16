<?php

namespace App\Http\Requests;

class UpdateVlogRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required_without_all:video_url|string',
            'video_url' => 'required_without_all:title|string'
        ];
    }
}