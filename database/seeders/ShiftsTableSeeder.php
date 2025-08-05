<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shifts')->insert([
            ['title' => 'شيفت صباحي', 'start_time' => '08:00:00', 'end_time' => '16:00:00'],
            ['title' => 'شيفت مسائي', 'start_time' => '12:00:00', 'end_time' => '20:00:00'],
            ['title' => 'شيفت ليلي', 'start_time' => '16:00:00', 'end_time' => '00:00:00'],
        ]);
    }
}
