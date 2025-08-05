<?php

namespace App\Http\Controllers\API\Profile;

use App\Models\Complaint;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Employee\EmployeeResource;
use App\Http\Requests\API\Employee\Issue\StoreIssueRequest;

class ProfileController extends Controller
{
    use HttpResponses;
    public function getProfile()
    {
        $user = Auth('employee')->user();
        return $this->successWithDataResponse( new EmployeeResource($user));
    }

    public function reportAnIssue(StoreIssueRequest $request)
    {
        Complaint::create($request->validated());
        return $this->successResponse('تم ارسال الشكوى بنجاح');
    }
}
