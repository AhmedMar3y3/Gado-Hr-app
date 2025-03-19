<?php
namespace App\Services;

use App\Models\Leave;
use App\Models\Employee;
use Carbon\Carbon;
use App\Enums\Status;

class LeaveService
{
    

    public function getLeaveStatistics($employee)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $allowedOffDays = $employee->off_days;
        $usedOffDays = $this->getUsedOffDays($employee, $year, $month);
        $remainingOffDays = $allowedOffDays - $usedOffDays;

        return [
            'allowed_off_days' => $allowedOffDays,
            'used_off_days' => $usedOffDays,
            'remaining_off_days' => $remainingOffDays,
        ];
    }

    public function getUsedOffDays($employee, $year, $month)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        return Leave::where('employee_id', $employee->id)
            ->where('status', Status::APPROVED->value)
            ->whereBetween('from', [$startDate, $endDate])
            ->sum('num_of_days');
    }

    public function createLeaveRequest($employee, $data)
    {
        $from = Carbon::parse($data['from']);
        $to = Carbon::parse($data['to']);
        $numOfDays = $from->diffInDays($to) + 1;

        $leave = Leave::create([
            'from' => $from,
            'to' => $to,
            'num_of_days' => $numOfDays,
            'status' => Status::PENDING->value,
            'employee_id' => $employee->id,
        ]);

        return $leave;
    }


    // for manager
    public function updateLeaveStatus(Leave $leave, $status)
    {
        $leave->update(['status' => $status]);
        return $leave;
    }

    public function getEmployeeLeaves($employee)
    {
        return $employee->leaves()->get();
    }
}