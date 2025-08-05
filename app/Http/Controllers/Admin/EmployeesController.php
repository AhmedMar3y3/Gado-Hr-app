<?php

namespace App\Http\Controllers\API\Admin;

use App\Enums\Role;
use App\Models\Employee;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\AddEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;

class EmployeesController extends Controller
{
    use HttpResponses;

    public function managers()
    {
        $managers = Employee::where('role', Role::MANAGER->value)->get(['id', 'name']);
        return $this->successWithDataResponse($managers);
    }

    public function AddEmployee(AddEmployeeRequest $request)
    {
        Employee::create($request->validated());
        return $this->successResponse('تم إضافة الموظف بنجاح');
    }

    public function updateEmployee(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->deleteManagerId($request);
        $employee->update($request->validated());
        return $this->successResponse('تم تعديل الموظف بنجاح');
    }
    public function deleteEmployee(Employee $employee)
    {
        $employee->delete();
        return $this->successResponse('تم حذف الموظف بنجاح');
    }

    //TODO: customize the response with a resource in the index and show methods

    public function allEmployees()
    {
        $employees = Employee::get(['id', 'name', 'role', 'username']);
        return $this->successWithDataResponse($employees);
    }
    public function showEmployee($id)
    {
        $employee = Employee::where('id', $id)->with('job', 'manager', 'shift', 'location')->get();
        return $this->successWithDataResponse($employee);
    }

    //TODO: CHeck for the password changing
    public function changeEmployeePassword(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update(['password' => $request->password]);
        return $this->successResponse('تم تعديل كلمة المرور بنجاح');
    }
}
