<?php
namespace App\Http\Controllers\API\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Filters\LeaveFilterRequest;
use App\Http\Requests\API\Leave\StoreLeaveRequest;
use App\Http\Resources\API\Leave\LeaveWithStatsResource;
use App\Services\LeaveService;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    use HttpResponses;
    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function index(LeaveFilterRequest $request)
    {
        $employee = Auth::guard('employee')->user();
        $month    = $request->getMonth();
        $year     = $request->getYear();

        $leaves     = $this->leaveService->getEmployeeLeaves($employee, $month, $year);
        $statistics = $this->leaveService->getLeaveStatistics($employee);

        $data = [
            'leaves'     => $leaves,
            'statistics' => $statistics,
        ];

        return $this->successWithDataResponse(new LeaveWithStatsResource($data));
    }

    public function store(StoreLeaveRequest $request)
    {
        $employee = Auth::guard('employee')->user();
        $this->leaveService->createLeaveRequest($employee, $request->validated());
        return $this->successResponse('تم ارسال طلب الاجازة بنجاح');
    }
}
