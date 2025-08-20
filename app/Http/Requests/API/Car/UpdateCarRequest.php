<?php
namespace App\Http\Requests\API\Car;

use App\Http\Requests\BaseRequest;
use App\Models\Employee;
use App\Models\Car;
use App\Enums\JobType;

class UpdateCarRequest extends BaseRequest
{
    public function rules(): array
    {
        $carId = $this->route('car');
        
        return [
            'model'           => 'nullable|string|max:255',
            'license_plate'   => 'nullable|string|max:255|unique:cars,license_plate,' . $carId,
            'license_issue'   => 'nullable|date',
            'license_renewal' => 'nullable|date',
            'last_oil_change' => 'nullable|date',
            'next_oil_change' => 'nullable|date',
            'employee_id'     => 'nullable|exists:employees,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $employeeId = $this->input('employee_id');
            
            if (!$employeeId) {
                return;
            }

            $employee = Employee::with('job')->find($employeeId);
            
            if (!$employee) {
                $validator->errors()->add('employee_id', 'الموظف غير موجود');
                return;
            }

            if ($employee->job->type !== JobType::DRIVER) {
                $validator->errors()->add('employee_id', 'يمكن إضافة السيارات للموظفين ذوي وظيفة السائق فقط');
                return;
            }

            $carId = $this->route('car');
            $existingCar = Car::where('employee_id', $employeeId)
                ->where('id', '!=', $carId)
                ->first();
                
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
