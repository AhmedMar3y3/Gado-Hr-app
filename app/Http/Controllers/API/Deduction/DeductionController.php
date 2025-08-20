<?php
namespace App\Http\Controllers\API\Deduction;

use App\Models\Deduction;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Deduction\DeductionResource;

class DeductionController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $user        = auth('employee')->user();
        $deductions  = Deduction::where('employee_id', $user->id) 
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->orderBy('created_at', 'desc')->get();
        return $this->successWithDataResponse(DeductionResource::collection($deductions));
    }
}
