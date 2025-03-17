<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'key' => 'distance',
                'value' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'deduction',
                'value' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
