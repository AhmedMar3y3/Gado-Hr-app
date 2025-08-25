<?php

namespace App\Http\Requests\API\Request;

use App\Enums\RequestType;
use App\Services\AttendanceRequestService;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Status;
use Carbon\Carbon;

class StoreAttendanceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date|after_or_equal:today',
            'requested_time' => 'required|date_format:H:i',
            'type' => 'required|in:late_clock_in,early_clock_out',
            'duration_minutes' => 'required|in:15,30,45',
            'reason' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'التاريخ مطلوب',
            'date.date' => 'التاريخ يجب أن يكون تاريخ صحيح',
            'date.after_or_equal' => 'التاريخ يجب أن يكون اليوم أو بعده',
            'requested_time.required' => 'الوقت المطلوب مطلوب',
            'requested_time.date_format' => 'الوقت يجب أن يكون بتنسيق صحيح (HH:MM)',
            'type.required' => 'نوع الطلب مطلوب',
            'type.in' => 'نوع الطلب يجب أن يكون تأخير في الحضور أو انصراف مبكر',
            'duration_minutes.required' => 'مدة الطلب مطلوبة',
            'duration_minutes.in' => 'مدة الطلب يجب أن تكون 15، 30، أو 45 دقيقة',
            'reason.required' => 'سبب الطلب مطلوب',
            'reason.string' => 'سبب الطلب يجب أن يكون نص',
            'reason.max' => 'سبب الطلب لا يمكن أن يتجاوز 500 حرف',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $employee = auth('employee')->user();
            $durationMinutes = $this->input('duration_minutes');
            $date = $this->input('date');
            $requestedTime = $this->input('requested_time');
            $type = $this->input('type');

            // Check if employee can request this duration
            $attendanceRequestService = app(AttendanceRequestService::class);
            $month = Carbon::parse($date)->month;
            $year = Carbon::parse($date)->year;

            if (!$attendanceRequestService->canRequestDuration($employee, $durationMinutes, $month, $year)) {
                $allowedRequests = $attendanceRequestService->getAllowedRequestsForDuration($durationMinutes);
                $validator->errors()->add('duration_minutes', "لا يمكن طلب {$durationMinutes} دقيقة أكثر من {$allowedRequests} مرات في الشهر");
                return;
            }

            // Check if employee has a shift
            if (!$employee->shift) {
                $validator->errors()->add('shift', 'لا يوجد جدول عمل محدد للموظف');
                return;
            }

            // Validate requested time against shift times
            $shiftStart = Carbon::parse($employee->shift->start_time);
            $shiftEnd = Carbon::parse($employee->shift->end_time);
            $requestedDateTime = Carbon::parse($date . ' ' . $requestedTime);

            if ($type === RequestType::LATE_CLOCK_IN->value) {
                $maxLateTime = $shiftStart->copy()->addMinutes(45);
                if ($requestedDateTime->gt($maxLateTime)) {
                    $validator->errors()->add('requested_time', 'لا يمكن طلب تأخير أكثر من 45 دقيقة عن وقت بداية العمل');
                    return;
                }
            } elseif ($type === RequestType::EARLY_CLOCK_OUT->value) {
                $minEarlyTime = $shiftEnd->copy()->subMinutes(45);
                if ($requestedDateTime->lt($minEarlyTime)) {
                    $validator->errors()->add('requested_time', 'لا يمكن طلب انصراف مبكر أكثر من 45 دقيقة عن وقت نهاية العمل');
                    return;
                }
            }

            // Check if there's already a request for the same date
            $existingRequest = $employee->requests()
                ->where('date', $date)
                ->where('status', '!=', Status::REJECTED)
                ->exists();

            if ($existingRequest) {
                $validator->errors()->add('date', 'يوجد طلب مسبق لهذا التاريخ');
                return;
            }
        });
    }
}
