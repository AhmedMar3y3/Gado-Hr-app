<?php

namespace App\Http\Requests\API\Issue;

use App\Http\Requests\BaseRequest;

class StoreIssueRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }
}
