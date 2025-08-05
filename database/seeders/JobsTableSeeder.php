<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jobs')->insert([
            ['title' => 'مشرف حركة', 'type' => 'driver'],
            ['title' => 'سائق', 'type' => 'driver'],
            ['title' => 'مشرف فني', 'type' => 'technician'],
            ['title' => 'فني', 'type' => 'technician'],
            ['title' => 'مساعد فني', 'type' => 'technician'],
            ['title' => 'مشرف مبيعات', 'type' => 'sales'],
            ['title' => 'مندوب مبيعات', 'type' => 'sales'],
            ['title' => 'عامل', 'type' => 'other'],
            ['title' => 'مدير حسابات', 'type' => 'other'],
            ['title' => 'حسابات', 'type' => 'other'],
            ['title' => 'مشرف تسويق', 'type' => 'other'],
            ['title' => 'تسويق', 'type' => 'other'],
            ['title' => 'مدير مخزن', 'type' => 'other'],
            ['title' => 'امين مخزن', 'type' => 'other'],
            ['title' => 'مساعد امين مخزن', 'type' => 'other'],
            ['title' => 'عامل مخزن', 'type' => 'other'],
        ]);
    }
};