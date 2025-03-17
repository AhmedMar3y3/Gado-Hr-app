<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeesTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('employees')->insert([
                'name' => 'Employee ' . $i,
                'username' => 'employee' . $i,
                'phone' => '987654321' . $i,
                'password' => Hash::make(123),
                'city' => 'City ' . $i,
                'age' => 25 + $i,
                'off_days' => 0,
                'salary' => 5000.00 + ($i * 100),
                'job_id' => ($i % 5) + 1,
                'manager_id' => null,
                'shift_id' => ($i % 3) + 1,
                'location_id' => rand(1, 5),
                'image' => null,
                'role' => $i % 2,
            ]);
        }
    }
}
