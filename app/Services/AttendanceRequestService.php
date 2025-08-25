<?php

namespace App\Services;

use App\Models\Request;
use App\Enums\Status;
use Carbon\Carbon;

class AttendanceRequestService
{
    public function createRequest($employee, array $data): Request
    {
        return Request::create([
            'date' => $data['date'],
            'requested_time' => $data['requested_time'],
            'type' => $data['type'],
            'duration_minutes' => $data['duration_minutes'],
            'reason' => $data['reason'],
            'status' => Status::PENDING,
            'employee_id' => $employee->id,
        ]);
    }

    public function getMonthlyRequestStats($employee, int $month = null, int $year = null): array
    {
        if (!$month) $month = Carbon::now()->month;
        if (!$year) $year = Carbon::now()->year;

        $requests = $employee->requests()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $totalRequests = $requests->count();
        $pendingRequests = $requests->where('status', Status::PENDING)->count();
        $approvedRequests = $requests->where('status', Status::APPROVED)->count();
        $rejectedRequests = $requests->where('status', Status::REJECTED)->count();

        // Count by duration
        $requests45min = $requests->where('duration_minutes', 45)->count();
        $requests30min = $requests->where('duration_minutes', 30)->count();
        $requests15min = $requests->where('duration_minutes', 15)->count();

        return [
            'total_requests' => $totalRequests,
            'pending_requests' => $pendingRequests,
            'approved_requests' => $approvedRequests,
            'rejected_requests' => $rejectedRequests,
            'requests_45min' => $requests45min,
            'requests_30min' => $requests30min,
            'requests_15min' => $requests15min,
            'remaining_45min' => 2 - $requests45min,
            'remaining_30min' => 1 - $requests30min,
            'remaining_15min' => 1 - $requests15min,
            'monthly_limit' => 4,
        ];
    }

    public function canRequestDuration($employee, int $durationMinutes, int $month = null, int $year = null): bool
    {
        if (!$month) $month = Carbon::now()->month;
        if (!$year) $year = Carbon::now()->year;

        $usedRequests = $employee->requests()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('duration_minutes', $durationMinutes)
            ->count();

        $allowedRequests = $this->getAllowedRequestsForDuration($durationMinutes);

        return $usedRequests < $allowedRequests;
    }

    public function getAllowedRequestsForDuration(int $durationMinutes): int
    {
        return match($durationMinutes) {
            45 => 2,
            30 => 1,
            15 => 1,
            default => 0,
        };
    }

    public function getEmployeeRequests($employee, int $month = null, int $year = null)
    {
        $query = $employee->requests();

        if ($month && $year) {
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getManagerEmployeeRequests($manager, int $month = null, int $year = null)
    {
        $employeeIds = $manager->employees->pluck('id');
        
        $query = Request::whereIn('employee_id', $employeeIds)
                        ->with('employee');

        if ($month && $year) {
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function approveRequest(Request $request): bool
    {
        return $request->update(['status' => Status::APPROVED]);
    }

    public function rejectRequest(Request $request): bool
    {
        return $request->update(['status' => Status::REJECTED]);
    }

    public function canManagerAccessRequest($manager, Request $request): bool
    {
        $managerEmployeeIds = $manager->employees->pluck('id');
        return $managerEmployeeIds->contains($request->employee_id);
    }
}
