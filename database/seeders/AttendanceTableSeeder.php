<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get all employees
        $employees = DB::table('employees')->get();

        foreach ($employees as $employee) {
            // Create attendance records for the last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                
                // Skip weekends (Friday and Saturday in some regions)
                if ($date->dayOfWeek == 5 || $date->dayOfWeek == 6) {
                    continue;
                }

                // Random attendance time (between 7:30 AM and 9:30 AM)
                $attendanceHour = rand(7, 9);
                $attendanceMinute = rand(0, 59);
                $attendanceTime = Carbon::createFromTime($attendanceHour, $attendanceMinute, 0);

                // Random departure time (between 4:00 PM and 6:00 PM)
                $departureHour = rand(16, 18);
                $departureMinute = rand(0, 59);
                $departureTime = Carbon::createFromTime($departureHour, $departureMinute, 0);

                // Determine status based on attendance time
                $status = AttendanceStatus::INTIME;
                $delay = 0;
                $overtime = 0;

                if ($attendanceTime->hour > 8 || ($attendanceTime->hour == 8 && $attendanceTime->minute > 0)) {
                    $status = AttendanceStatus::LATE;
                    $delay = $attendanceTime->diffInMinutes(Carbon::createFromTime(8, 0, 0));
                } elseif ($attendanceTime->hour < 8) {
                    $status = AttendanceStatus::EARLY;
                    $overtime = Carbon::createFromTime(8, 0, 0)->diffInMinutes($attendanceTime);
                }

                // Add overtime for late departure
                if ($departureTime->hour > 16) {
                    $overtime += $departureTime->diffInMinutes(Carbon::createFromTime(16, 0, 0));
                }

                DB::table('attendances')->insert([
                    'employee_id' => $employee->id,
                    'date' => $date->toDateString(),
                    'attendance' => $attendanceTime->toTimeString(),
                    'departure' => $departureTime->toTimeString(),
                    'status' => $status->value,
                    'total_delay' => $delay,
                    'overtime' => $overtime,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
