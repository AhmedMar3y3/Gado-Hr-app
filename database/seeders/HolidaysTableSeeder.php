<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaysTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('holidays')->insert([
            ['from' => '2025-08-30', 'to' => '2025-08-31', 'title' => 'عيد الأضحى'],
            ['from' => '2025-09-01', 'to' => '2025-09-02', 'title' => 'عيد الأضحى'],
            ['from' => '2025-09-03', 'to' => '2025-09-04', 'title' => 'عيد الأضحى'],
        ]);
    }
}