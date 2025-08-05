<?php

namespace App\Http\Controllers\API\Meeting;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\MeetingResource;

class MeetingController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $employee = auth('employee')->user();

        $meetings = $employee->meetings()
            ->where('date', today())
            ->with(['participants' => function ($query) {
                $query->select('employees.id', 'employees.image');
            }])
            ->get();

        return $this->successWithDataResponse(MeetingResource::collection($meetings));
    }
}
