<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Auth\AuthResource;
use App\Http\Requests\API\Auth\LoginEmployeeRequest;

class AuthController extends Controller
{
    use HttpResponses;

    //Login User
    public function login(LoginEmployeeRequest $request)
    {
        $user = Employee::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->failureResponse('البريد الإلكتروني أو كلمة المرور غير صحيحة');
        }

        return $this->successWithDataResponse(AuthResource::make($user)->setToken($user->login()));
    }

    //Logout User
    public function logout(Request $request)
    {
        $request->user('employee')->currentAccessToken()->delete();
        return $this->successResponse('تم تسجيل الخروج بنجاح');
    }
}
