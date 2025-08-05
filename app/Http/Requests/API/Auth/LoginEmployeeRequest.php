<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseRequest;

class LoginEmployeeRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
