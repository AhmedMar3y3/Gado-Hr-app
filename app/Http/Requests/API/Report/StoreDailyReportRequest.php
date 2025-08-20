<?php

namespace App\Http\Requests\API\Report;

use App\Http\Requests\BaseRequest;
use App\Enums\JobType;

class StoreDailyReportRequest extends BaseRequest
{
    public function rules(): array
    {
        $employee = auth('employee')->user();
        $jobType = $employee->job->type;

        $rules = [
            'content' => 'required|string',
        ];

        switch ($jobType) {
            case JobType::DRIVER:
                $rules['num_of_devices'] = 'required|integer|min:0';
                $rules['overtime_hours'] = 'required|numeric|min:0';
                break;
            
            case JobType::SALES:
                $rules['sold_devices'] = 'required|integer|min:0';
                $rules['bought_devices'] = 'required|integer|min:0';
                $rules['commercial_devices'] = 'required|integer|min:0';
                break;
            
            case JobType::TECHNICIAN:
                $rules['num_of_devices'] = 'required|integer|min:0';
                $rules['num_of_meters'] = 'required|numeric|min:0';
                break;
            
            case JobType::OTHER:
                $rules['overtime_hours'] = 'required|numeric|min:0';
                break;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'content.required' => 'محتوى التقرير مطلوب',
            'num_of_devices.required' => 'عدد الأجهزة مطلوب',
            'num_of_devices.integer' => 'عدد الأجهزة يجب أن يكون رقم صحيح',
            'num_of_devices.min' => 'عدد الأجهزة يجب أن يكون صفر أو أكثر',
            'num_of_meters.required' => 'عدد الأمتار مطلوب',
            'num_of_meters.numeric' => 'عدد الأمتار يجب أن يكون رقم',
            'num_of_meters.min' => 'عدد الأمتار يجب أن يكون صفر أو أكثر',
            'overtime_hours.required' => 'ساعات العمل الإضافي مطلوبة',
            'overtime_hours.numeric' => 'ساعات العمل الإضافي يجب أن تكون رقم',
            'overtime_hours.min' => 'ساعات العمل الإضافي يجب أن تكون صفر أو أكثر',
            'sold_devices.required' => 'عدد الأجهزة المباعة مطلوب',
            'sold_devices.integer' => 'عدد الأجهزة المباعة يجب أن يكون رقم صحيح',
            'sold_devices.min' => 'عدد الأجهزة المباعة يجب أن يكون صفر أو أكثر',
            'bought_devices.required' => 'عدد الأجهزة المشتراة مطلوب',
            'bought_devices.integer' => 'عدد الأجهزة المشتراة يجب أن يكون رقم صحيح',
            'bought_devices.min' => 'عدد الأجهزة المشتراة يجب أن يكون صفر أو أكثر',
            'commercial_devices.required' => 'عدد الأجهزة التجارية مطلوب',
            'commercial_devices.integer' => 'عدد الأجهزة التجارية يجب أن يكون رقم صحيح',
            'commercial_devices.min' => 'عدد الأجهزة التجارية يجب أن يكون صفر أو أكثر',
        ];
    }
}
