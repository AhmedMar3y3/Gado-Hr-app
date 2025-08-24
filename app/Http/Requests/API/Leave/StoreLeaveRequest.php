<?php

namespace App\Http\Requests\API\Leave;

use App\Http\Requests\BaseRequest;
use App\Models\Leave;
use App\Enums\Status;
use Carbon\Carbon;

class StoreLeaveRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $employee = auth('employee')->user();
            $from = Carbon::parse($this->input('from'));
            $to = Carbon::parse($this->input('to'));
            
            $requestedDays = $from->diffInDays($to) + 1;
            
            $monthStart = $from->copy()->startOfMonth();
            $monthEnd = $from->copy()->endOfMonth();
            
            $monthlyLeaves = Leave::where('employee_id', $employee->id)
                ->where('status', Status::APPROVED)
                ->where(function ($query) use ($monthStart, $monthEnd) {
                    $query->whereBetween('from', [$monthStart, $monthEnd])
                          ->orWhereBetween('to', [$monthStart, $monthEnd])
                          ->orWhere(function ($q) use ($monthStart, $monthEnd) {
                              $q->where('from', '<=', $monthStart)
                                ->where('to', '>=', $monthEnd);
                          });
                })
                ->sum('num_of_days');
            
            $totalMonthlyDays = $monthlyLeaves + $requestedDays;
            
            if ($totalMonthlyDays > 7) {
                $validator->errors()->add('to', 'لا يمكن طلب أكثر من 7 أيام إجازة في الشهر الواحد');
                return;
            }
            
            $yearStart = $from->copy()->startOfYear();
            $yearEnd = $from->copy()->endOfYear();
            
            $yearlyLeaves = Leave::where('employee_id', $employee->id)
                ->where('status', Status::APPROVED)
                ->where(function ($query) use ($yearStart, $yearEnd) {
                    $query->whereBetween('from', [$yearStart, $yearEnd])
                          ->orWhereBetween('to', [$yearStart, $yearEnd])
                          ->orWhere(function ($q) use ($yearStart, $yearEnd) {
                              $q->where('from', '<=', $yearStart)
                                ->where('to', '>=', $yearEnd);
                          });
                })
                ->sum('num_of_days');
            
            $totalYearlyDays = $yearlyLeaves + $requestedDays;
            
            if ($totalYearlyDays > $employee->off_days) {
                $validator->errors()->add('to', "لا يمكن طلب أكثر من {$employee->off_days} أيام إجازة في السنة");
                return;
            }
            
            $overlappingLeaves = Leave::where('employee_id', $employee->id)
                ->where('status', Status::APPROVED)
                ->where(function ($query) use ($from, $to) {
                    $query->whereBetween('from', [$from, $to])
                          ->orWhereBetween('to', [$from, $to])
                          ->orWhere(function ($q) use ($from, $to) {
                              $q->where('from', '<=', $from)
                                ->where('to', '>=', $to);
                          });
                })
                ->exists();
            
            if ($overlappingLeaves) {
                $validator->errors()->add('from', 'هناك تداخل مع إجازة موجودة في هذه الفترة');
                return;
            }
        });
    }
}
