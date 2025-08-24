<?php
namespace App\Http\Controllers\API\Advance;

use App\Traits\HttpResponses;
use App\Services\AdvanceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Advance\StoreAdvanceRequest;
use App\Http\Requests\API\Filters\AdvanceFilterRequest;
use App\Http\Resources\API\Advance\AdvanceWithStatsResource;

class AdvanceController extends Controller
{
    use HttpResponses;

    protected $advanceService;

    public function __construct(AdvanceService $advanceService)
    {
        $this->advanceService = $advanceService;
    }

    public function index(AdvanceFilterRequest $request)
    {
        $employee = auth('employee')->user();
        $month    = $request->getMonth();
        $year     = $request->getYear();

        $advances = $this->advanceService->getEmployeeAdvances($employee, $month, $year);
        $stats    = $this->advanceService->getAdvanceStats($employee, $month, $year);

        $data = [
            'advances' => $advances,
            'stats'    => $stats,
        ];

        return $this->successWithDataResponse(new AdvanceWithStatsResource($data));
    }

    public function store(StoreAdvanceRequest $request)
    {
        $employee = auth('employee')->user();
        $this->advanceService->createAdvance($employee, $request->validated());
        return $this->successResponse('تم إنشاء طلب السلفة بنجاح');
    }
}
