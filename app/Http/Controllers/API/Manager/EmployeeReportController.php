<?php

namespace App\Http\Controllers\API\Manager;

use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Manger\Report\UpdateReportRequest;
use App\Http\Resources\API\Manager\ReportDetailsResource;
use App\Traits\HttpResponses;
use App\Http\Resources\API\Manager\ReportsResource;

class EmployeeReportController extends Controller
{
    use HttpResponses;

    public function employeeReports()
    {
        $user = auth('employee')->user();
        if (!$user->checkRole($user->role)) {
            return $this->failureResponse('غير مسموح لك بعرض تقارير الموظفين');
        }
        $employeeIds = $user->employees->pluck('id');
        $reports = Report::whereIn('employee_id', $employeeIds)->where('is_confirmed', 0)->get();
            
        return $this->successWithDataResponse(ReportsResource::collection($reports));
    }

    public function show($id)
    {
        $user = auth('employee')->user();
        if (!$user->checkRole($user->role)) {
            return $this->failureResponse('غير مسموح لك بعرض هذا التقرير');
        }
        $report = Report::findOrFail($id);
        if (!$report) {
            return $this->failureResponse('التقرير غير موجود');
        }
        return $this->successWithDataResponse(new ReportDetailsResource($report));
    }
    
    public function update(UpdateReportRequest $request, $id)
    {
        $user = auth('employee')->user();

        $report = Report::findOrFail($id);
        if (!$report) {
            return $this->failureResponse('التقرير غير موجود');
        }
        if (!$user->checkRole($user->role)) {
            return $this->failureResponse('غير مسموح لك بتعديل هذا التقرير');
        }
       
        $report->update($request->validated());
        return $this->successResponse('تم تعديل التقرير بنجاح');
    }

    public function confirmReport($id)
    {
        $user = auth('employee')->user();

        $report = Report::findOrFail($id);
        if (!$report) {
            return $this->failureResponse('التقرير غير موجود');
        }
        if (!$user->checkRole($user->role)) {
            return $this->failureResponse('غير مسموح لك بتأكيد هذا التقرير');
        }
        $report->update(['is_confirmed' => 1]);
        return $this->successResponse('تم تأكيد التقرير بنجاح');
    }
}
