<?php

namespace App\Http\Controllers\API\Attendence;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\AttendanceService;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Attendence\DepartureResource;
use App\Http\Resources\API\Attendence\AttendanceResource;

class AttendanceController extends Controller
{
    use HttpResponses;
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function attendance(Request $request)
    {
        $employee = Auth('employee')->user();
        if (!$employee) {
            return $this->failureResponse('لم يتم العثور على الموظف.');
        }

        $currentLat = $request->input('latitude');
        $currentLon = $request->input('longitude');

        if (empty($currentLat) || empty($currentLon)) {
            return $this->failureResponse('خطأ: يجب إدخال خط العرض وخط الطول.');
        }

        if (!$this->attendanceService->isWithinDistance($employee, $currentLat, $currentLon)) {
            return $this->failureResponse('أنت لست ضمن المسافة المسموح بها من الموقع.');
        }

        $currentTime = Carbon::now();
        $date = $currentTime->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $date)
            ->first();

        if (!$attendance) {
            if ($this->attendanceService->recordCheckIn($employee, $currentTime)) {
                return $this->successWithDataAndMessageResponse('تم تسجيل الحضور بنجاح.', 'attendance');
            }
            return $this->failureResponse('حدث خطأ أثناء تسجيل الحضور.');
        } elseif ($attendance->attendance && !$attendance->departure) {
            if ($this->attendanceService->recordCheckOut($employee, $currentTime)) {
                return $this->successWithDataAndMessageResponse('تم تسجيل المغادرة بنجاح.', 'departure');
            }
            return $this->failureResponse('حدث خطأ أثناء تسجيل المغادرة.');
        } else {
            return $this->failureResponse('لقد أكملت الحضور والمغادرة لهذا اليوم.');
        }
    }

    public function attendanceHistory(Request $request)
    {
        $employee = Auth('employee')->user();
        $month = $request->input('month');
        $year = $request->input('year');

        $attendances = $this->attendanceService->getAttendanceHistory($employee, $month, $year);

        return $this->successWithDataResponse(AttendanceResource::collection($attendances));
    }

    public function departureHistory(Request $request)
    {
        $employee = Auth('employee')->user();
        $month = $request->input('month');
        $year = $request->input('year');

        $departures = $this->attendanceService->getDepartureHistory($employee, $month, $year);
        return $this->successWithDataResponse(DepartureResource::collection($departures));
    }
}
