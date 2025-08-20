<?php

namespace Database\Seeders;

use App\Enums\JobType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get employees with their job types
        $employees = DB::table('employees')
            ->join('jobs', 'employees.job_id', '=', 'jobs.id')
            ->select('employees.id', 'employees.role', 'jobs.type')
            ->get();

        foreach ($employees as $employee) {
            // Create reports for the last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                // Only auto-confirm manager reports, employees need manual confirmation
                $isConfirmed = $employee->role == 1;
                
                $reportData = [
                    'date' => $date->toDateString(),
                    'content' => 'تقرير يومي لـ ' . ($employee->role == 1 ? 'المدير' : 'الموظف') . ' بتاريخ ' . $date->format('Y-m-d'),
                    'employee_id' => $employee->id,
                    'is_confirmed' => $isConfirmed,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];

                // Add job-specific fields based on job type
                switch ($employee->type) {
                    case JobType::DRIVER->value:
                        $reportData['num_of_devices'] = rand(5, 20);
                        $reportData['overtime_hours'] = rand(0, 4);
                        break;
                    
                    case JobType::SALES->value:
                        $reportData['sold_devices'] = rand(10, 50);
                        $reportData['bought_devices'] = rand(5, 25);
                        $reportData['commercial_devices'] = rand(2, 15);
                        break;
                    
                    case JobType::TECHNICIAN->value:
                        $reportData['num_of_devices'] = rand(3, 12);
                        $reportData['num_of_meters'] = rand(100, 500);
                        break;
                    
                    case JobType::OTHER->value:
                        $reportData['overtime_hours'] = rand(0, 3);
                        break;
                }

                DB::table('reports')->insert($reportData);
            }
        }
    }
}
