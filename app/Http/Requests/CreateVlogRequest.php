<?php

namespace App\Http\Requests;

class CreateVlogRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'video_url' => 'required|string'
        ];
    }
}
