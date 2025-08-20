<?php
namespace App\Http\Requests\API\Car;

use App\Http\Requests\BaseRequest;
use App\Models\Employee;
use App\Models\Car;
use App\Enums\JobType;

class StoreCarRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'model'           => 'required|string|max:255',
            'license_plate'   => 'required|string|max:255|unique:cars,license_plate',
            'license_issue'   => 'required|date',
            'license_renewal' => 'required|date',
            'last_oil_change' => 'required|date',
            'next_oil_change' => 'required|date',
            'employee_id'     => 'required|exists:employees,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $employeeId = $this->input('employee_id');
            
            $employee = Employee::with('job')->find($employeeId);
            
            if (!$employee) {
                $validator->errors()->add('employee_id', 'الموظف غير موجود');
                return;
            }

            if ($employee->job->type !== JobType::DRIVER) {
                $validator->errors()->add('employee_id', 'يمكن إضافة السيارات للموظفين ذوي وظيفة السائق فقط');
                return;
            }

            $existingCar = Car::where('employee_id', $employeeId)->first();
            if ($existingCar) {
                $validator->errors()->add('employee_id', 'هذا الموظف لديه سيارة بالفعل');
                return;
            }

            $manager = auth('employee')->user();
            $managerEmployeeIds = $manager->employees->pluck('id');
            
            if (!$managerEmployeeIds->contains($employeeId)) {
                $validator->errors()->add('employee_id', 'لا يمكنك إضافة سيارة لهذا الموظف');
                return;
            }
        });
    }
}
