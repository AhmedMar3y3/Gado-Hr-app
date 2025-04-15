<?php

namespace App\Http\Controllers\API\Manager;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Manager\EmployeesResource;

class EmployeesController extends Controller
{
    use HttpResponses;
    public function employees(){
        $user = Auth('employee')->user();
        return $this->successWithDataResponse(EmployeesResource::collection($user->employees));
    }
}
