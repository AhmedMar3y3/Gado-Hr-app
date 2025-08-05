<?php

namespace App\Http\Controllers\API\Report;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Employee\Report\StoreReportRequest;
use App\Http\Resources\API\Employee\ReportDetailsResource;
use App\Http\Resources\API\Employee\ReportsResource;

class ReportController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $reports = auth('employee')->user()->reports()->get();
        return $this->successWithDataResponse(ReportsResource::collection($reports));
    }

    public function show($id)
    {
        $report = auth('employee')->user()->reports()->findOrFail($id);
        if (!$report) {
            return $this->failureResponse('التقرير غير موجود');
        }
        return $this->successWithDataResponse(new ReportDetailsResource($report));
    }
    public function store(StoreReportRequest $request)
    {
        $user = auth('employee')->user();
        if ($user->checkRole($user->role)) {
            $user->reports()->create($request->validated() + ['date' => today(), 'is_confirmed' => 1]);
            return $this->successResponse('تم اضافة التقرير بنجاح');
        }
        $user->reports()->create($request->validated() + ['date' => today()]);
        return $this->successResponse('تم اضافة التقرير بنجاح');
    }
}
