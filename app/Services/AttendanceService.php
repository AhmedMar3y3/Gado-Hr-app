<?php

namespace App\Services;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Setting;
use Carbon\Carbon;

class AttendanceService
{
    public function isWithinDistance($employee, $currentLat, $currentLon): bool
    {
        $office = $employee->location;
        $officeLat = $office->lat;
        $officeLon = $office->lng;

        if($office->is_remote) {
            return true;
        }

        $allowedDistance = (float) Setting::where('key', 'distance')->value('value') / 1000;
        $distance = $this->calculateDistance($currentLat, $currentLon, $officeLat, $officeLon);

        return $distance <= $allowedDistance;
    }

    // Record the employee's attendance
    public function recordCheckIn($employee, Carbon $currentTime): bool
    {
        $date = $currentTime->toDateString();
        $attendanceTime = $currentTime->toTimeString();

        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', $date)
                                ->first();

        if ($attendance && $attendance->attendance) {
            return false;
        }

        $shift = $employee->shift;
        $shiftStart = Carbon::createFromFormat('H:i:s', $shift->start_time)
                            ->setDate($currentTime->year, $currentTime->month, $currentTime->day);

        $delay = 0;
        $overtime = 0;

        if ($currentTime->lessThan($shiftStart)) {
            $status = AttendanceStatus::EARLY;
            $overtime = $shiftStart->diffInMinutes($currentTime);
        } elseif ($currentTime->greaterThan($shiftStart)) {
            $status = AttendanceStatus::LATE;
            $delay = $currentTime->diffInMinutes($shiftStart);
        } else {
            $status = AttendanceStatus::INTIME;
        }

        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->employee_id = $employee->id;
            $attendance->date = $date;
        }

        $attendance->attendance = $attendanceTime;
        $attendance->status = $status->value;
        $attendance->total_delay = $delay;
        $attendance->overtime = $overtime;
        $attendance->save();

        return true;
    }

    // Record the employee's departure
    public function recordCheckOut($employee, Carbon $currentTime): bool
    {
        $date = $currentTime->toDateString();
        $departureTime = $currentTime->toTimeString();

        $attendance = Attendance::where('employee_id', $employee->id)
                                ->where('date', $date)
                                ->first();

        if (!$attendance || !$attendance->attendance || $attendance->departure) {
            return false;
        }

        $shift = $employee->shift;
        $shiftEnd = Carbon::createFromFormat('H:i:s', $shift->end_time)
                          ->setDate($currentTime->year, $currentTime->month, $currentTime->day);

        if ($currentTime->lessThan($shiftEnd)) {
            $earlyDeparture = $shiftEnd->diffInMinutes($currentTime);
            $attendance->total_delay += $earlyDeparture;
        } elseif ($currentTime->greaterThan($shiftEnd)) {
            $lateDeparture = $currentTime->diffInMinutes($shiftEnd);
            $attendance->overtime += $lateDeparture;
        }

        $attendance->departure = $departureTime;
        $attendance->save();

        return true;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function getAttendanceHistory($employee, $month = null, $year = null)
    {
        $query = $employee->attendances()->orderBy('date', 'asc');

        if ($month && $year) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        return $query->get();
    }

    public function getDepartureHistory($employee, $month = null, $year = null)
    {
        $query = $employee->attendances()->whereNotNull('departure')->orderBy('date', 'desc');

        if ($month && $year) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        return $query->get();
    }
}