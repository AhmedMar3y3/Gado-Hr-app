<?php

namespace App\Http\Controllers\API\Attendence;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\AttendanceService;
use App\Services\DailyReportService;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Attendence\AttendanceResource;
use App\Http\Requests\API\Filters\AttendanceFilterRequest;

class AttendanceController extends Controller
{
    use HttpResponses;
    protected $attendanceService;
    protected $dailyReportService;

    public function __construct(AttendanceService $attendanceService, DailyReportService $dailyReportService)
    {
        $this->attendanceService = $attendanceService;
        $this->dailyReportService = $dailyReportService;
    }

    public function attendance(Request $request)
    {
        $employee = Auth('employee')->user();
        if (!$employee) {
            return $this->failureResponse('لم يتم العثور على الموظف.');
        }

        if (empty($request->input('latitude')) || empty($request->input('longitude'))) {
            return $this->failureResponse('خطأ: يجب إدخال خط العرض وخط الطول.');
        }

        if (!$this->attendanceService->isWithinDistance($employee, $request->input('latitude'), $request->input('longitude'))) {
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
            
            if (!$this->dailyReportService->hasDailyReport($employee)) {
                return $this->failureResponse('يجب تقديم التقرير اليومي قبل تسجيل المغادرة.');
            }
            
            if ($this->attendanceService->recordCheckOut($employee, $currentTime)) {
                return $this->successWithDataAndMessageResponse('تم تسجيل المغادرة بنجاح.', 'departure');
            }
            return $this->failureResponse('حدث خطأ أثناء تسجيل المغادرة.');
        } else {
            return $this->failureResponse('لقد أكملت الحضور والمغادرة لهذا اليوم.');
        }
    }

    public function attendanceHistory(AttendanceFilterRequest $request)
    {
        $employee = Auth('employee')->user();
        $month = $request->getMonth();
        $year = $request->getYear();
        
        $attendances = $this->attendanceService->getCombinedAttendanceHistory($employee, $month, $year);
        return $this->successWithDataResponse(AttendanceResource::collection($attendances));
    }
}
