<?php

namespace App\Http\Requests;

class PasswordResetRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['email' => 'required|email|exists:users'];
    }
}
