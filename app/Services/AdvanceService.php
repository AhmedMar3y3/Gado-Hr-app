<?php
namespace App\Services;

use App\Enums\AdvanceType;
use App\Enums\Status;
use App\Models\Advance;
use App\Models\Setting;

class AdvanceService
{
    public function createAdvance($employee,array $data): Advance
    {
        $advanceData = [
            'type'        => $data['type'],
            'amount'      => $data['amount'],
            'employee_id' => $employee->id,
            'status'      => Status::PENDING,
        ];

        if ($data['type'] === AdvanceType::LONG_TERM->value) {
            $advanceData['number_of_months'] = $data['number_of_months'];
        }

        return Advance::create($advanceData);
    }

    public function isLongTermAdvanceEnabled(): bool
    {
        $setting = Setting::where('key', 'is_longterm_advance_enabled')->first();
        return $setting && $setting->value == '1';
    }

    public function getEmployeeAdvances($employee, int $month = null, int $year = null)
    {
        $query = $employee->advances()->with('employee');

        if ($month && $year) {
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getManagerEmployeeAdvances($manager, int $month = null, int $year = null)
    {
        $employeeIds = $manager->employees->pluck('id');

        $query = Advance::whereIn('employee_id', $employeeIds)
            ->with('employee');

        if ($month && $year) {
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getAdvanceStats($employee, int $month = null, int $year = null): array
    {
        $query = $employee->advances();

        if ($month && $year) {
            $query->whereYear('created_at', $year);
        }

        $advances          = $query->get();
        $latestAdvanceDate = $advances->max('created_at');

        return [
            'latest_advance_date' => $latestAdvanceDate ? $latestAdvanceDate->format('Y-m-d') : null,
        ];
    }

    public function getManagerAdvanceStats($manager, int $month = null, int $year = null): array
    {
        $employeeIds = $manager->employees->pluck('id');

        $query = Advance::whereIn('employee_id', $employeeIds);

        if ($month && $year) {
            $query->whereYear('created_at', $year);
        }

        $advances          = $query->get();
        $latestAdvanceDate = $advances->max('created_at');

        return [
            'latest_advance_date' => $latestAdvanceDate ? $latestAdvanceDate->format('Y-m-d') : null,
        ];
    }

    public function approveAdvance(Advance $advance): bool
    {
        return $advance->update(['status' => Status::APPROVED]);
    }

    public function rejectAdvance(Advance $advance): bool
    {
        return $advance->update(['status' => Status::REJECTED]);
    }

    public function canManagerAccessAdvance($manager, Advance $advance): bool
    {
        $managerEmployeeIds = $manager->employees->pluck('id');
        return $managerEmployeeIds->contains($advance->employee_id);
    }
}
