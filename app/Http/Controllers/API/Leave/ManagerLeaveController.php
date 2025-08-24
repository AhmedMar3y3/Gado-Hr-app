<?php
namespace App\Http\Controllers\API\Leave;

use App\Models\Leave;
use App\Traits\HttpResponses;
use App\Services\LeaveService;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Leave\LeaveDetailsResource;

class ManagerLeaveController extends Controller
{
    use HttpResponses;

    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function leaveDetails(Leave $leave)
    {
        $manager = auth('employee')->user();

        if (! $this->leaveService->canManagerAccessLeave($manager, $leave)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }
        
        return $this->successWithDataResponse(new LeaveDetailsResource($leave));
    }

    public function approveLeave(Leave $leave)
    {
        $manager            = auth('employee')->user();
        $managerEmployeeIds = $manager->employees->pluck('id');

        if (! $managerEmployeeIds->contains($leave->employee_id)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        if ($leave->status !== \App\Enums\Status::PENDING) {
            return $this->failureResponse('لا يمكن الموافقة على طلب غير معلق');
        }

        $this->leaveService->approveLeave($leave);

        return $this->successResponse('تم الموافقة على طلب الإجازة بنجاح');
    }

    public function rejectLeave(Leave $leave)
    {
        $manager            = auth('employee')->user();
        $managerEmployeeIds = $manager->employees->pluck('id');

        if (! $managerEmployeeIds->contains($leave->employee_id)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        if ($leave->status !== \App\Enums\Status::PENDING) {
            return $this->failureResponse('لا يمكن رفض طلب غير معلق');
        }

        $this->leaveService->rejectLeave($leave);
        return $this->successResponse('تم رفض طلب الإجازة بنجاح');
    }
}
