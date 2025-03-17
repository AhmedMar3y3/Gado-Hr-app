<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jobs')->insert([
            ['title' => 'Software Developer'],
            ['title' => 'Project Manager'],
            ['title' => 'Designer'],
            ['title' => 'QA Engineer'],
            ['title' => 'DevOps Engineer'],
        ]);
    }
}