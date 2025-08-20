<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create managers first
        for ($i = 1; $i <= 3; $i++) {
            DB::table('employees')->insert([
                'name' => 'Manager ' . $i,
                'username' => 'manager' . $i,
                'phone' => '987654321' . $i,
                'password' => Hash::make(123),
                'city' => 'City ' . $i,
                'age' => 30 + $i,
                'off_days' => 0,
                'salary' => 8000.00 + ($i * 200),
                'device_price' => 50.00 + ($i * 10),
                'meter_price' => 25.00 + ($i * 5),
                'overtime_hour_price' => 100.00 + ($i * 15),
                'sold_device_price' => 75.00 + ($i * 12),
                'bought_device_price' => 60.00 + ($i * 8),
                'commercial_device_price' => 90.00 + ($i * 15),
                'job_id' => ($i % 4) + 1, // Mix of job types for managers
                'manager_id' => null,
                'shift_id' => ($i % 3) + 1,
                'location_id' => rand(1, 5),
                'image' => null,
                'role' => 1, // Manager role
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create regular employees
        for ($i = 1; $i <= 15; $i++) {
            $managerId = ($i <= 5) ? 1 : (($i <= 10) ? 2 : 3); // Assign to different managers
            
            DB::table('employees')->insert([
                'name' => 'Employee ' . $i,
                'username' => 'employee' . $i,
                'phone' => '987654321' . ($i + 10),
                'password' => Hash::make(123),
                'city' => 'City ' . ($i + 3),
                'age' => 25 + $i,
                'off_days' => 0,
                'salary' => 5000.00 + ($i * 100),
                'device_price' => 40.00 + ($i * 5),
                'meter_price' => 20.00 + ($i * 3),
                'overtime_hour_price' => 80.00 + ($i * 10),
                'sold_device_price' => 60.00 + ($i * 8),
                'bought_device_price' => 45.00 + ($i * 6),
                'commercial_device_price' => 70.00 + ($i * 10),
                'job_id' => ($i % 16) + 1, // Use all job types
                'manager_id' => $managerId,
                'shift_id' => ($i % 3) + 1,
                'location_id' => rand(1, 5),
                'image' => null,
                'role' => 0, // Employee role
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
