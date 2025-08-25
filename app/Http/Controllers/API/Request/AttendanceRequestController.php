<?php
namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Filters\RequestFilterRequest;
use App\Http\Requests\API\Request\StoreAttendanceRequestRequest;
use App\Http\Resources\API\Request\AttendanceRequestWithStatsResource;
use App\Services\AttendanceRequestService;
use App\Traits\HttpResponses;

class AttendanceRequestController extends Controller
{
    use HttpResponses;

    protected $attendanceRequestService;

    public function __construct(AttendanceRequestService $attendanceRequestService)
    {
        $this->attendanceRequestService = $attendanceRequestService;
    }

    public function index(RequestFilterRequest $request)
    {
        $employee = auth('employee')->user();
        $month    = $request->getMonth();
        $year     = $request->getYear();

        $requests = $this->attendanceRequestService->getEmployeeRequests($employee, $month, $year);
        $stats    = $this->attendanceRequestService->getMonthlyRequestStats($employee, $month, $year);

        $data = [
            'requests' => $requests,
            'stats'    => $stats,
        ];

        return $this->successWithDataResponse(new AttendanceRequestWithStatsResource($data));
    }

    public function store(StoreAttendanceRequestRequest $request)
    {
        $employee = auth('employee')->user();
        $data     = $request->validated();

        $data['requested_time'] = $data['date'] . ' ' . $data['requested_time'];

        $this->attendanceRequestService->createRequest($employee, $data);

        return $this->successWithDataResponse('تم إرسال طلب الحضور بنجاح');
    }
}
