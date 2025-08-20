<?php

namespace App\Http\Requests\API\Report;

use App\Http\Requests\BaseRequest;
use App\Enums\JobType;
use App\Models\Report;

class UpdateDailyReportRequest extends BaseRequest
{
    public function rules(): array
    {
        $report = Report::with('employee.job')->find($this->route('id'));
        $jobType = $report->employee->job->type;

        $rules = [
            'content' => 'sometimes|string',
        ];

        switch ($jobType) {
            case JobType::DRIVER:
                $rules['num_of_devices'] = 'sometimes|integer|min:0';
                $rules['overtime_hours'] = 'sometimes|numeric|min:0';
                break;
            
            case JobType::SALES:
                $rules['sold_devices'] = 'sometimes|integer|min:0';
                $rules['bought_devices'] = 'sometimes|integer|min:0';
                $rules['commercial_devices'] = 'sometimes|integer|min:0';
                break;
            
            case JobType::TECHNICIAN:
                $rules['num_of_devices'] = 'sometimes|integer|min:0';
                $rules['num_of_meters'] = 'sometimes|numeric|min:0';
                break;
            
            case JobType::OTHER:
                $rules['overtime_hours'] = 'sometimes|numeric|min:0';
                break;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'content.string' => 'محتوى التقرير يجب أن يكون نص',
            'num_of_devices.integer' => 'عدد الأجهزة يجب أن يكون رقم صحيح',
            'num_of_devices.min' => 'عدد الأجهزة يجب أن يكون صفر أو أكثر',
            'num_of_meters.numeric' => 'عدد الأمتار يجب أن يكون رقم',
            'num_of_meters.min' => 'عدد الأمتار يجب أن يكون صفر أو أكثر',
            'overtime_hours.numeric' => 'ساعات العمل الإضافي يجب أن تكون رقم',
            'overtime_hours.min' => 'ساعات العمل الإضافي يجب أن تكون صفر أو أكثر',
            'sold_devices.integer' => 'عدد الأجهزة المباعة يجب أن يكون رقم صحيح',
            'sold_devices.min' => 'عدد الأجهزة المباعة يجب أن يكون صفر أو أكثر',
            'bought_devices.integer' => 'عدد الأجهزة المشتراة يجب أن يكون رقم صحيح',
            'bought_devices.min' => 'عدد الأجهزة المشتراة يجب أن يكون صفر أو أكثر',
            'commercial_devices.integer' => 'عدد الأجهزة التجارية يجب أن يكون رقم صحيح',
            'commercial_devices.min' => 'عدد الأجهزة التجارية يجب أن يكون صفر أو أكثر',
        ];
    }
}
