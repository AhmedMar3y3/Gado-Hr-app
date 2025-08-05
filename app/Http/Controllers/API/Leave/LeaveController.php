<?php

namespace App\Http\Controllers\API\Leave;

use App\Traits\HttpResponses;
use App\Services\LeaveService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Employee\LeaveResource;
use App\Http\Requests\API\Employee\Leave\StoreLeaveRequest;
use App\Http\Resources\API\Employee\LeaveStatisticsResource;

class LeaveController extends Controller
{
    use HttpResponses;
    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function index()
    {
        $employee = Auth::guard('employee')->user();
        $leaves = $this->leaveService->getEmployeeLeaves($employee);
        return $this->successWithDataResponse(LeaveResource::collection($leaves));
    }

    public function store(StoreLeaveRequest $request)
    {
        $employee = Auth::guard('employee')->user();
        $this->leaveService->createLeaveRequest($employee, $request->validated());
        return $this->successResponse('تم ارسال طلب الاجازة بنجاح');
    }


    public function statistics()
    {
        $employee = Auth::guard('employee')->user();
        $statistics = $this->leaveService->getLeaveStatistics($employee);
        return $this->successWithDataResponse(new LeaveStatisticsResource($statistics));
    }
}
