<?php

namespace App\Http\Controllers\API\Request;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Filters\RequestFilterRequest;
use App\Http\Resources\API\Request\AttendanceRequestResource;
use App\Services\AttendanceRequestService;
use App\Models\Request;

class ManagerAttendanceRequestController extends Controller
{
    use HttpResponses;

    protected $attendanceRequestService;

    public function __construct(AttendanceRequestService $attendanceRequestService)
    {
        $this->attendanceRequestService = $attendanceRequestService;
    }

    public function employeeRequests(RequestFilterRequest $request)
    {
        $manager = auth('employee')->user();
        $month = $request->getMonth();
        $year = $request->getYear();

        $requests = $this->attendanceRequestService->getManagerEmployeeRequests($manager, $month, $year);

        return $this->successWithDataResponse(AttendanceRequestResource::collection($requests));
    }

    public function requestDetails(Request $attendanceRequest)
    {
        $manager = auth('employee')->user();

        if (!$this->attendanceRequestService->canManagerAccessRequest($manager, $attendanceRequest)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        return $this->successWithDataResponse(new AttendanceRequestResource($attendanceRequest));
    }

    public function approveRequest(Request $attendanceRequest)
    {
        $manager = auth('employee')->user();

        if (!$this->attendanceRequestService->canManagerAccessRequest($manager, $attendanceRequest)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        if ($attendanceRequest->status !== \App\Enums\Status::PENDING) {
            return $this->failureResponse('لا يمكن الموافقة على طلب غير معلق');
        }

        $this->attendanceRequestService->approveRequest($attendanceRequest);

        return $this->successResponse('تم الموافقة على طلب الحضور بنجاح');
    }

    public function rejectRequest(Request $attendanceRequest)
    {
        $manager = auth('employee')->user();

        if (!$this->attendanceRequestService->canManagerAccessRequest($manager, $attendanceRequest)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        if ($attendanceRequest->status !== \App\Enums\Status::PENDING) {
            return $this->failureResponse('لا يمكن رفض طلب غير معلق');
        }

        $this->attendanceRequestService->rejectRequest($attendanceRequest);

        return $this->successResponse('تم رفض طلب الحضور بنجاح');
    }
}
