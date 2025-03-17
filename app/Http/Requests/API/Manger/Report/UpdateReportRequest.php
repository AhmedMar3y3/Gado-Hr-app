<?php

namespace App\Http\Requests\API\Manger\Report;

use App\Http\Requests\BaseRequest;

class UpdateReportRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'addition_target' => 'nullable|string',
            'addition_overtime' => 'nullable|numeric',
        ];
    }

}
