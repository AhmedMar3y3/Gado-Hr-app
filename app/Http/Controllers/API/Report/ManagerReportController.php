<?php

namespace App\Http\Controllers\API\Report;

use App\Models\Report;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\DailyReportService;
use App\Http\Requests\API\Filters\ReportFilterRequest;
use App\Http\Resources\API\Report\ManagerReportsResource;
use App\Http\Requests\API\Report\UpdateDailyReportRequest;
use App\Http\Resources\API\Report\ManagerDetailedReportResource;

class ManagerReportController extends Controller
{
    use HttpResponses;
    protected $dailyReportService;

    public function __construct(DailyReportService $dailyReportService)
    {
        $this->dailyReportService = $dailyReportService;
    }

    public function employeeReports(ReportFilterRequest $request)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $today = now()->toDateString();

        $reports = Report::whereIn('employee_id', $employeeIds)
            ->with('employee.job')
            ->where('is_confirmed', false)
            ->whereDate('date', $today)
            ->orderBy('created_at', 'desc')
            ->get(); 
            
        return $this->successWithDataResponse(ManagerReportsResource::collection($reports));
    }

    public function show($id)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $report = Report::whereIn('employee_id', $employeeIds)->with('employee.job')->findOrFail($id);
        return $this->successWithDataResponse(new ManagerDetailedReportResource($report));
    }
    
    public function update(UpdateDailyReportRequest $request, $id)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $report = Report::whereIn('employee_id', $employeeIds)->with('employee.job')->findOrFail($id);
        
        $this->dailyReportService->updateReport($report, $request->validated());
        return $this->successResponse('تم تعديل التقرير بنجاح');
    }

    public function confirmReport($id)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $report = Report::whereIn('employee_id', $employeeIds)->findOrFail($id);
        $report->update(['is_confirmed' => 1]);
        return $this->successResponse('تم تأكيد التقرير بنجاح');
    }
}
