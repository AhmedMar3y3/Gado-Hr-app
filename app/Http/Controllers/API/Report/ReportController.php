<?php

namespace App\Http\Controllers\API\Report;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\DailyReportService;
use App\Http\Resources\API\Report\ReportsResource;
use App\Http\Resources\API\Report\ReportDetailsResource;
use App\Http\Requests\API\Report\StoreDailyReportRequest;
use App\Http\Requests\API\Filters\ReportFilterRequest;

class ReportController extends Controller
{
    use HttpResponses;
    protected $dailyReportService;

    public function __construct(DailyReportService $dailyReportService)
    {
        $this->dailyReportService = $dailyReportService;
    }

    public function index(ReportFilterRequest $request)
    {
        $employee = auth('employee')->user();
        $month = $request->getMonth();
        $year = $request->getYear();
        
        $reports = $employee->reports()->with('employee.job')->where('is_confirmed', true)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();
            
        return $this->successWithDataResponse(ReportsResource::collection($reports));
    }

    public function show($id)
    {
        $report = auth('employee')->user()->reports()->with('employee.job')->findOrFail($id);
        return $this->successWithDataResponse(new ReportDetailsResource($report));
    }

    public function storeDailyReport(StoreDailyReportRequest $request)
    {
        $employee = auth('employee')->user();
        
        if ($this->dailyReportService->hasDailyReport($employee)) {
            return $this->failureResponse('لقد قمت بتقديم التقرير اليومي بالفعل.');
        }
        $this->dailyReportService->createDailyReport($employee, $request->validated());
        return $this->successResponse('تم تقديم التقرير اليومي بنجاح.');
    }
}
