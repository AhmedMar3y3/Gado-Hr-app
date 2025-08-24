<?php
namespace App\Http\Controllers\API\EmployeeRequests;

use App\Models\Leave;
use App\Models\Advance;
use App\Traits\HttpResponses;
use App\Services\LeaveService;
use App\Services\AdvanceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Filters\AdvanceFilterRequest;
use App\Http\Resources\API\Manager\EmployeeRequestResource;

class RequestsController extends Controller
{
    use HttpResponses;

    protected $advanceService;
    protected $leaveService;

    public function __construct(AdvanceService $advanceService, LeaveService $leaveService)
    {
        $this->advanceService = $advanceService;
        $this->leaveService   = $leaveService;
    }

    public function employeeRequests(AdvanceFilterRequest $request)
    {
        $manager = auth('employee')->user();
        $month   = $request->getMonth();
        $year    = $request->getYear();

        $employeeIds     = $manager->employees->pluck('id');
        $pendingAdvances = Advance::whereIn('employee_id', $employeeIds)
            ->where('status', \App\Enums\Status::PENDING)
            ->with('employee')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingLeaves = Leave::whereIn('employee_id', $employeeIds)
            ->where('status', \App\Enums\Status::PENDING)
            ->with('employee')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        $allRequests = $pendingAdvances->concat($pendingLeaves)->sortByDesc('created_at');

        return $this->successWithDataResponse(EmployeeRequestResource::collection($allRequests));
    }

    public function requestDetails($id, $type)
    {
        $manager     = auth('employee')->user();
        $employeeIds = $manager->employees->pluck('id');

        if ($type === 'advance') {
            $request = Advance::whereIn('employee_id', $employeeIds)
                ->with('employee')
                ->find($id);
        } elseif ($type === 'leave') {
            $request = Leave::whereIn('employee_id', $employeeIds)
                ->with('employee')
                ->find($id);
        } else {
            return $this->failureResponse('نوع الطلب غير صحيح');
        }

        if (! $request) {
            return $this->failureResponse('الطلب غير موجود');
        }

        return $this->successWithDataResponse(new EmployeeRequestResource($request));
    }

    public function approveRequest($id, $type)
    {
        $manager     = auth('employee')->user();
        $employeeIds = $manager->employees->pluck('id');

        if ($type === 'advance') {
            $request = Advance::whereIn('employee_id', $employeeIds)->find($id);
            if (! $request) {
                return $this->failureResponse('طلب السلفة غير موجود');
            }
            if ($request->status !== \App\Enums\Status::PENDING) {
                return $this->failureResponse('لا يمكن الموافقة على طلب غير معلق');
            }
            $this->advanceService->approveAdvance($request);
            return $this->successResponse('تم الموافقة على طلب السلفة بنجاح');
        } elseif ($type === 'leave') {
            $request = Leave::whereIn('employee_id', $employeeIds)->find($id);
            if (! $request) {
                return $this->failureResponse('طلب الإجازة غير موجود');
            }
            if ($request->status !== \App\Enums\Status::PENDING) {
                return $this->failureResponse('لا يمكن الموافقة على طلب غير معلق');
            }
            $this->leaveService->approveLeave($request);
            return $this->successResponse('تم الموافقة على طلب الإجازة بنجاح');
        }

        return $this->failureResponse('نوع الطلب غير صحيح');
    }

    public function rejectRequest($id, $type)
    {
        $manager     = auth('employee')->user();
        $employeeIds = $manager->employees->pluck('id');

        if ($type === 'advance') {
            $request = Advance::whereIn('employee_id', $employeeIds)->find($id);
            if (! $request) {
                return $this->failureResponse('طلب السلفة غير موجود');
            }
            if ($request->status !== \App\Enums\Status::PENDING) {
                return $this->failureResponse('لا يمكن رفض طلب غير معلق');
            }
            $this->advanceService->rejectAdvance($request);
            return $this->successResponse('تم رفض طلب السلفة بنجاح');
        } elseif ($type === 'leave') {
            $request = Leave::whereIn('employee_id', $employeeIds)->find($id);
            if (! $request) {
                return $this->failureResponse('طلب الإجازة غير موجود');
            }
            if ($request->status !== \App\Enums\Status::PENDING) {
                return $this->failureResponse('لا يمكن رفض طلب غير معلق');
            }
            $this->leaveService->rejectLeave($request);
            return $this->successResponse('تم رفض طلب الإجازة بنجاح');
        }

        return $this->failureResponse('نوع الطلب غير صحيح');
    }
}
