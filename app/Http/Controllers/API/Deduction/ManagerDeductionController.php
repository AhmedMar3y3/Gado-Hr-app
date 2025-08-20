<?php
namespace App\Http\Controllers\API\Deduction;

use App\Models\Deduction;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Deduction\StoreDeductionRequest;
use App\Http\Resources\API\Deduction\ManagerDeductionResource;

class ManagerDeductionController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $deductions = Deduction::whereIn('employee_id', $employeeIds)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->orderBy('created_at', 'desc')->get();
        return $this->successWithDataResponse(ManagerDeductionResource::collection($deductions));
    }
    public function store(StoreDeductionRequest $request)
    {
        Deduction::create($request->validated() + ['date' => today()]);
        return $this->successResponse('تم إنشاء الخصم بنجاح');
    }
}
