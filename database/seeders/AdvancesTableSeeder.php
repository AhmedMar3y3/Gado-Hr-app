<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advance;
use App\Models\Employee;
use App\Enums\AdvanceType;
use App\Enums\Status;
use Carbon\Carbon;

class AdvancesTableSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Create 2-4 advances per employee
            $numAdvances = rand(2, 4);
            
            for ($i = 0; $i < $numAdvances; $i++) {
                $type = rand(0, 1) === 0 ? AdvanceType::NORMAL : AdvanceType::LONG_TERM;
                $status = rand(0, 2); // 0: pending, 1: approved, 2: rejected
                
                $advanceData = [
                    'type' => $type,
                    'amount' => rand(1000, 10000),
                    'employee_id' => $employee->id,
                    'status' => $status,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30)),
                ];

                // Add number_of_months for long term advances
                if ($type === AdvanceType::LONG_TERM) {
                    $advanceData['number_of_months'] = rand(3, 24);
                }

                Advance::create($advanceData);
            }
        }
    }
}
