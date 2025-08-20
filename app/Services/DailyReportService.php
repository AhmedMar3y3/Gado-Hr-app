<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Employee;
use App\Enums\JobType;

class DailyReportService
{
    public function hasDailyReport($employee): bool
    {
        return $employee->reports()->where('date', Carbon::today())->exists();
    }

    public function getTodayReport($employee): ?Report
    {
        return $employee->reports()->where('date', Carbon::today())->first();
    }

    public function createDailyReport($employee, array $data): Report
    {
        $reportData = [
            'date' => Carbon::today(),
            'content' => $data['content'],
            'employee_id' => $employee->id,
            'is_confirmed' => $employee->role->value === 1,
        ];

        $jobType = $employee->job->type;
        
        switch ($jobType) {
            case JobType::DRIVER:
                $reportData['num_of_devices'] = $data['num_of_devices'];
                $reportData['overtime_hours'] = $data['overtime_hours'];
                break;
            
            case JobType::SALES:
                $reportData['sold_devices'] = $data['sold_devices'];
                $reportData['bought_devices'] = $data['bought_devices'];
                $reportData['commercial_devices'] = $data['commercial_devices'];
                break;
            
            case JobType::TECHNICIAN:
                $reportData['num_of_devices'] = $data['num_of_devices'];
                $reportData['num_of_meters'] = $data['num_of_meters'];
                break;
            
            case JobType::OTHER:
                $reportData['overtime_hours'] = $data['overtime_hours'];
                break;
        }

        return $employee->reports()->create($reportData);
    }

    public function validateReportData($employee, array $data): array
    {
        $jobType = $employee->job->type;
        $errors = [];

        switch ($jobType) {
            case JobType::DRIVER:
                if (!isset($data['num_of_devices'])) {
                    $errors[] = 'عدد الأجهزة مطلوب للسائق';
                }
                if (!isset($data['overtime_hours'])) {
                    $errors[] = 'ساعات العمل الإضافي مطلوبة للسائق';
                }
                break;
            
            case JobType::SALES:
                if (!isset($data['sold_devices'])) {
                    $errors[] = 'عدد الأجهزة المباعة مطلوب للمبيعات';
                }
                if (!isset($data['bought_devices'])) {
                    $errors[] = 'عدد الأجهزة المشتراة مطلوب للمبيعات';
                }
                if (!isset($data['commercial_devices'])) {
                    $errors[] = 'عدد الأجهزة التجارية مطلوب للمبيعات';
                }
                break;
            
            case JobType::TECHNICIAN:
                if (!isset($data['num_of_devices'])) {
                    $errors[] = 'عدد الأجهزة مطلوب للفني';
                }
                if (!isset($data['num_of_meters'])) {
                    $errors[] = 'عدد الأمتار مطلوب للفني';
                }
                break;
            
            case JobType::OTHER:
                if (!isset($data['overtime_hours'])) {
                    $errors[] = 'ساعات العمل الإضافي مطلوبة';
                }
                break;
        }

        return $errors;
    }

    public function getRequiredFields($employee): array
    {
        $jobType = $employee->job->type;
        
        switch ($jobType) {
            case JobType::DRIVER:
                return ['num_of_devices', 'overtime_hours'];
            
            case JobType::SALES:
                return ['sold_devices', 'bought_devices', 'commercial_devices'];
            
            case JobType::TECHNICIAN:
                return ['num_of_devices', 'num_of_meters'];
            
            case JobType::OTHER:
                return ['overtime_hours'];
            
            default:
                return [];
        }
    }

    /**
     * Update report with job-specific field filtering
     */
    public function updateReport(Report $report, array $data): Report
    {
        $jobType = $report->employee->job->type;
        $updateData = [];

        // Always allow content update
        if (isset($data['content'])) {
            $updateData['content'] = $data['content'];
        }

        // Add job-specific fields based on employee's job type
        switch ($jobType) {
            case JobType::DRIVER:
                if (isset($data['num_of_devices'])) {
                    $updateData['num_of_devices'] = $data['num_of_devices'];
                }
                if (isset($data['overtime_hours'])) {
                    $updateData['overtime_hours'] = $data['overtime_hours'];
                }
                break;
            
            case JobType::SALES:
                if (isset($data['sold_devices'])) {
                    $updateData['sold_devices'] = $data['sold_devices'];
                }
                if (isset($data['bought_devices'])) {
                    $updateData['bought_devices'] = $data['bought_devices'];
                }
                if (isset($data['commercial_devices'])) {
                    $updateData['commercial_devices'] = $data['commercial_devices'];
                }
                break;
            
            case JobType::TECHNICIAN:
                if (isset($data['num_of_devices'])) {
                    $updateData['num_of_devices'] = $data['num_of_devices'];
                }
                if (isset($data['num_of_meters'])) {
                    $updateData['num_of_meters'] = $data['num_of_meters'];
                }
                break;
            
            case JobType::OTHER:
                if (isset($data['overtime_hours'])) {
                    $updateData['overtime_hours'] = $data['overtime_hours'];
                }
                break;
        }

        $report->update($updateData);
        return $report;
    }
}
