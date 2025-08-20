<?php

namespace App\Http\Requests\API\Deduction;

use App\Http\Requests\BaseRequest;

class StoreDeductionRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'amount'      => 'required|numeric|min:0',
            'type'        => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id',
        ];
    }
}