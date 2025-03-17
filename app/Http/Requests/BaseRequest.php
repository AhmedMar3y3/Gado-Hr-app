<?php

namespace App\Http\Requests;

use App\Traits\HttpResponses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    use HttpResponses;

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator) {
        if (request()->is('api/*','admin/*')) {
            throw new HttpResponseException($this->failureResponse($validator->errors()->first()));
        }else{
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
