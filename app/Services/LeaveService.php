<?php
namespace App\Services;

use App\Enums\Status;
use App\Models\Leave;
use Carbon\Carbon;

class LeaveService
{

    public function getLeaveStatistics($employee)
    {
        $year             = Carbon::now()->year;
        $allowedOffDays   = $employee->off_days;
        $usedOffDays      = $this->getUsedOffDays($employee, $year);
        $remainingOffDays = $allowedOffDays - $usedOffDays;

        return [
            'allowed_off_days'   => $allowedOffDays,
            'used_off_days'      => $usedOffDays,
            'remaining_off_days' => $remainingOffDays,
        ];
    }

    public function getUsedOffDays($employee, $year)
    {
        $startDate = Carbon::create($year, 1, 1)->startOfYear();
        $endDate   = $startDate->copy()->endOfYear();

        return Leave::where('employee_id', $employee->id)
            ->where('status', Status::APPROVED)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('from', [$startDate, $endDate])
                    ->orWhereBetween('to', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('from', '<=', $startDate)
                            ->where('to', '>=', $endDate);
                    });
            })
            ->sum('num_of_days');
    }

    public function createLeaveRequest($employee, $data)
    {
        $from      = Carbon::parse($data['from']);
        $to        = Carbon::parse($data['to']);
        $numOfDays = $from->diffInDays($to) + 1;

        $leave = Leave::create([
            'from'        => $from,
            'to'          => $to,
            'num_of_days' => $numOfDays,
            'status'      => Status::PENDING,
            'employee_id' => $employee->id,
        ]);

        return $leave;
    }

    public function updateLeaveStatus(Leave $leave, $status)
    {
        $leave->update(['status' => $status]);
        return $leave;
    }

    public function approveLeave(Leave $leave)
    {
        return $this->updateLeaveStatus($leave, Status::APPROVED);
    }

    public function rejectLeave(Leave $leave)
    {
        return $this->updateLeaveStatus($leave, Status::REJECTED);
    }

    public function getEmployeeLeaves($employee, int $month = null, int $year = null)
    {
        $query = $employee->leaves();

        if ($month && $year) {
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function canManagerAccessLeave($manager, Leave $leave): bool
    {
        $managerEmployeeIds = $manager->employees->pluck('id');
        return $managerEmployeeIds->contains($leave->employee_id);
    }
}
