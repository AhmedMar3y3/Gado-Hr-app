<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request;
use App\Models\Employee;
use App\Enums\RequestType;
use App\Enums\Status;
use Carbon\Carbon;

class AttendanceRequestsTableSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Create 1-3 attendance requests per employee
            $numRequests = rand(1, 3);
            
            for ($i = 0; $i < $numRequests; $i++) {
                $type = rand(0, 1) === 0 ? RequestType::LATE_CLOCK_IN : RequestType::EARLY_CLOCK_OUT;
                $status = rand(0, 2); // 0: pending, 1: approved, 2: rejected
                
                // Random duration: 15, 30, or 45 minutes
                $durations = [15, 30, 45];
                $durationMinutes = $durations[array_rand($durations)];
                
                // Random date within the last 30 days
                $date = Carbon::now()->subDays(rand(1, 30));
                
                // Random time based on type
                if ($type === RequestType::LATE_CLOCK_IN) {
                    $requestedTime = Carbon::createFromTime(rand(9, 12), rand(0, 59), 0);
                } else {
                    $requestedTime = Carbon::createFromTime(rand(14, 17), rand(0, 59), 0);
                }

                Request::create([
                    'date' => $date->format('Y-m-d'),
                    'requested_time' => $date->format('Y-m-d') . ' ' . $requestedTime->format('H:i:00'),
                    'type' => $type,
                    'duration_minutes' => $durationMinutes,
                    'reason' => $this->getRandomReason($type),
                    'status' => $status,
                    'employee_id' => $employee->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }

    private function getRandomReason(RequestType $type): string
    {
        $lateReasons = [
            'موعد طبي',
            'مشكلة في المواصلات',
            'ظروف عائلية طارئة',
            'مشكلة تقنية في المنزل',
            'تأخير في الاستيقاظ',
        ];

        $earlyReasons = [
            'موعد طبي',
            'التزام عائلي مهم',
            'مشكلة صحية',
            'موعد رسمي',
            'ظروف طارئة',
        ];

        $reasons = $type === RequestType::LATE_CLOCK_IN ? $lateReasons : $earlyReasons;
        return $reasons[array_rand($reasons)];
    }
}
