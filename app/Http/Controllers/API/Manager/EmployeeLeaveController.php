<?php

namespace App\Http\Controllers\API\Manager;

use App\Models\Leave;
use App\Enums\Status;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Manager\LeavesResource;
use App\Http\Resources\API\Manager\LeaveDetailsResource;

class EmployeeLeaveController extends Controller
{
    use HttpResponses;
    public function employeeLeaves()
    {
        $user = Auth('employee')->user();
        $leaves = Leave::where('status',Status::PENDING->value)->whereHas('employee', function ($query) use ($user) {
            $query->where('manager_id', $user->id);
        })->with('employee')->get();
        return $this->successWithDataResponse(LeavesResource::collection($leaves));
    }

    public function leaveDetails($id)
    {
        $leave = Leave::find($id);
        return $this->successWithDataResponse(new LeaveDetailsResource($leave));
    }

    public function acceptLeave($id)
    {
        $leave = Leave::find($id);
        $leave->update(['status' => Status::APPROVED->value]);
        return $this->successResponse('تم قبول الطلب بنجاح');
    }
    public function rejectLeave($id)
    {
        $leave = Leave::find($id);
        $leave->update(['status' => Status::REJECTED->value]);
        return $this->successResponse('تم رفض الطلب بنجاح');
    }
}
