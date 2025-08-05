<?php

namespace App\Http\Requests\API\Report;

use App\Http\Requests\BaseRequest;

class UpdateReportRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'addition_target' => 'nullable|string',
            'addition_overtime' => 'nullable|numeric',
        ];
    }

}
