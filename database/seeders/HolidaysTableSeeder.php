<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaysTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('holidays')->insert([
            ['date' => '2023-01-01', 'title' => 'New Year\'s Day', 'type' => 'public'],
            ['date' => '2023-12-25', 'title' => 'Christmas Day', 'type' => 'public'],
            ['date' => '2023-07-04', 'title' => 'Independence Day', 'type' => 'public'],
        ]);
    }
}