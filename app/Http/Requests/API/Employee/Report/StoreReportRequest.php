<?php

namespace App\Http\Requests\API\Employee\Report;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Target = 1, Overtime = 2, Nothing = 0
        return [
            'content' => 'required|string',
            'addition' => 'required|in:0,1,2',
            'addition_target' => 'required_if:addition,1|string|prohibited_if:addition,0,2',
            'addition_overtime' => 'required_if:addition,2|numeric|prohibited_if:addition,0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'addition_target.required_if' => 'حقل الهدف مطلوب عند اختيار الهدف',
            'addition_overtime.required_if' => 'حقل الوقت الاضافي مطلوب عند اختيار الوقت الاضافي',
            'addition_target.prohibited_if' => 'حقل الهدف ممنوع عند عدم اختيار الهدف',
            'addition_overtime.prohibited_if' => 'حقل الوقت الاضافي ممنوع عند عدم اختيار الوقت الاضافي',
        ];
    }
}
