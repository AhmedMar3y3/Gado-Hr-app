<?php

namespace App\Http\Controllers\API\Employee;

use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\AttendanceService;
use App\Http\Controllers\Controller;
use App\Models\Attendance;

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
                return $this->successResponse('تم تسجيل الحضور بنجاح.');
            }
            return $this->failureResponse('حدث خطأ أثناء تسجيل الحضور.');
        }
        elseif ($attendance->attendance && !$attendance->departure) {
            if ($this->attendanceService->recordCheckOut($employee, $currentTime)) {
                return $this->successResponse('تم تسجيل المغادرة بنجاح.');
            }
            return $this->failureResponse('حدث خطأ أثناء تسجيل المغادرة.');
        }
        else {
            return $this->failureResponse('لقد أكملت الحضور والمغادرة لهذا اليوم.');
        }
    }
}