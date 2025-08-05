<?php

namespace App\Http\Controllers\API\Profile;

use App\Models\Complaint;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Issue\StoreIssueRequest;
use App\Http\Resources\API\Employee\ProfileResource;

class ProfileController extends Controller
{
    use HttpResponses;
    public function getProfile()
    {
        $user = Auth('employee')->user();
        return $this->successWithDataResponse( new ProfileResource($user));
    }

    public function reportAnIssue(StoreIssueRequest $request)
    {
        Complaint::create($request->validated());
        return $this->successResponse('تم ارسال الشكوى بنجاح');
    }
}
