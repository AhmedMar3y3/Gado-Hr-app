<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseRequest;

class StoreForgotPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|exists:employees,username',
        ];
    }
}
