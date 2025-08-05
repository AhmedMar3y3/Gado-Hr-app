<?php

namespace App\Http\Controllers\API\Meeting;

use App\Models\Meeting;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\MeetingResource;
use App\Http\Requests\API\Meeting\StoreMeetingRequest;
use App\Http\Resources\API\Employee\EmployeesResource;

class ManagerMeetingController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $user = auth('employee')->user();
        $meetings = Meeting::where('employee_id',$user->id)
        ->where('date',today())->with('participants')->get();
        return $this->successWithDataResponse(MeetingResource::collection($meetings));
    }
    public function store(StoreMeetingRequest $request)
    {
        $meeting = Meeting::create($request->validated() + ['employee_id' => auth('employee')->id()]);
        $meeting->participants()->attach($request->participants);
        return $this->successResponse('تم إنشاء الاجتماع بنجاح');
    }

       public function employees(){
        $user = Auth('employee')->user();
        return $this->successWithDataResponse(EmployeesResource::collection($user->employees));
    }
}
