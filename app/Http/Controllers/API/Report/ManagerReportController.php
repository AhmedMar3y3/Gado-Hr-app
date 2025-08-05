<?php

namespace App\Http\Controllers\API\Report;

use App\Models\Report;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Report\UpdateReportRequest;
use App\Http\Resources\API\Report\EmployeeReportsResource;
use App\Http\Resources\API\Report\EmployeeReportDetailsResource;

class ManagerReportController extends Controller
{
    use HttpResponses;

    public function employeeReports()
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $reports = Report::whereIn('employee_id', $employeeIds)->where('is_confirmed', 0)->get(); 
        return $this->successWithDataResponse(EmployeeReportsResource::collection($reports));
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        if (!$report) {
            return $this->failureResponse('التقرير غير موجود');
        }
        return $this->successWithDataResponse(new EmployeeReportDetailsResource($report));
    }
    
    public function update(UpdateReportRequest $request, $id)
    {
        $report = Report::findOrFail($id);
        if (!$report) {
            return $this->failureResponse('التقرير غير موجود');
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
        $report->update(['is_confirmed' => 1]);
        return $this->successResponse('تم تأكيد التقرير بنجاح');
    }
}
