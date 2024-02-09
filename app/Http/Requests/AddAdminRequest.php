<?php

namespace App\Http\Requests;

class AddAdminRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'send_details' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'send_details.required' => 'Indicate if login details should be emailed to user',
            'send_details.boolean' => 'Select only True or False',
        ];
    }
}
