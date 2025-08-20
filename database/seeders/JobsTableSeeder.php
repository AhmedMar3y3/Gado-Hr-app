<?php
namespace Database\Seeders;

use App\Enums\JobType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jobs')->insert([
            ['title' => 'مشرف حركة', 'type' => JobType::DRIVER],
            ['title' => 'سائق', 'type' => JobType::DRIVER],
            ['title' => 'مشرف فني', 'type' => JobType::TECHNICIAN],
            ['title' => 'فني', 'type' => JobType::TECHNICIAN],
            ['title' => 'مساعد فني', 'type' => JobType::TECHNICIAN],
            ['title' => 'مشرف مبيعات', 'type' => JobType::SALES],
            ['title' => 'مندوب مبيعات', 'type' => JobType::SALES],
            ['title' => 'عامل', 'type' => JobType::OTHER],
            ['title' => 'مدير حسابات', 'type' => JobType::OTHER],
            ['title' => 'حسابات', 'type' => JobType::OTHER],
            ['title' => 'مشرف تسويق', 'type' => JobType::OTHER],
            ['title' => 'تسويق', 'type' => JobType::OTHER],
            ['title' => 'مدير مخزن', 'type' => JobType::OTHER],
            ['title' => 'امين مخزن', 'type' => JobType::OTHER],
            ['title' => 'مساعد امين مخزن', 'type' => JobType::OTHER],
            ['title' => 'عامل مخزن', 'type' => JobType::OTHER],
        ]);
    }
};