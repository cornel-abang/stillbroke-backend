<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{   
    /**
     * @return array
     */
    abstract public function rules();

    /**
     * @return bool
     */
    abstract public function authorize();

    /**
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
       
         $response = response()->json([
            'success' => false,
            'message' => 'User validation failed',
            'errors' => $errors
         ], 401);
            
         throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());


    }
}