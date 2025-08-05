<?php

namespace App\Http\Requests\API\Leave;

use App\Http\Requests\BaseRequest;

class StoreLeaveRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ];
    }
}
