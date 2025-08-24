<?php
namespace App\Http\Controllers\API\Employee;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Employee\EmployeesResource;
use App\Http\Resources\API\Employee\DetailedEmployeeResource;

class EmployeesController extends Controller
{
    use HttpResponses;

    public function getEmployees()
    {
        $manager = auth('employee')->user();
        return $this->successWithDataResponse(EmployeesResource::collection($manager->employees));
    }

    public function showEmployeeDetails($id)
    {
        $manager  = auth('employee')->user();
        $employee = $manager->employees()->find($id);

        if (! $employee) {
            return $this->failureResponse('لم يتم العثور على الموظف');
        }

        return $this->successWithDataResponse(new DetailedEmployeeResource($employee));
    }

}
