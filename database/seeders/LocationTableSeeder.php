<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'title' => 'Office',
                'is_remote' => false,
                'lat' => 40.712776,
                'lng' => -74.005974,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sales',
                'is_remote' => true,
                'lat' => null,
                'lng' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Store',
                'is_remote' => false,
                'lat' => 51.507351,
                'lng' => -0.127758,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Home',
                'is_remote' => true,
                'lat' => null,
                'lng' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hunger',
                'is_remote' => false,
                'lat' => 35.689487,
                'lng' => 139.691711,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
