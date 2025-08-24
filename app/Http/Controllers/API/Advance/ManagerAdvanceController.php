<?php
namespace App\Http\Controllers\API\Advance;

use App\Models\Advance;
use App\Traits\HttpResponses;
use App\Services\AdvanceService;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Advance\AdvanceResource;
use App\Http\Resources\API\Advance\AdvanceDetailsResource;

class ManagerAdvanceController extends Controller
{
    use HttpResponses;

    protected $advanceService;
    public function __construct(AdvanceService $advanceService)
    {
        $this->advanceService = $advanceService;
    }

    public function advanceDetails(Advance $advance)
    {
        $manager = auth('employee')->user();

        if (! $this->advanceService->canManagerAccessAdvance($manager, $advance)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        return $this->successWithDataResponse(new AdvanceDetailsResource($advance));
    }

    public function approveAdvance(Advance $advance)
    {
        $manager = auth('employee')->user();

        if (! $this->advanceService->canManagerAccessAdvance($manager, $advance)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        if ($advance->status !== \App\Enums\Status::PENDING) {
            return $this->failureResponse('لا يمكن الموافقة على طلب غير معلق');
        }

        $this->advanceService->approveAdvance($advance);

        return $this->successResponse('تم الموافقة على طلب السلفة بنجاح');
    }

    public function rejectAdvance(Advance $advance)
    {
        $manager = auth('employee')->user();

        if (! $this->advanceService->canManagerAccessAdvance($manager, $advance)) {
            return $this->failureResponse('لا يمكنك الوصول لهذا الطلب');
        }

        if ($advance->status !== \App\Enums\Status::PENDING) {
            return $this->failureResponse('لا يمكن رفض طلب غير معلق');
        }

        $this->advanceService->rejectAdvance($advance);

        return $this->successResponse('تم رفض طلب السلفة بنجاح');
    }
}
