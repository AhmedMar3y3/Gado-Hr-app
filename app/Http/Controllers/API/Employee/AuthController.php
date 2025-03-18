<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\Employee;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Employee\Auth\LoginEmployeeRequest;
use App\Http\Resources\AuthResource;

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

        $token = $user->createToken("Api token of {$user->name}")->plainTextToken;
        return $this->successWithDataResponse(AuthResource::make($user)->setToken($token));
    }
    //Logout User
    public function logout()
    {
        try {
           
            Auth('employee')->user()->tokens()->delete();
            return $this->successResponse('تم تسجيل الخروج بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse('فشل تسجيل الخروج: ' . $e->getMessage());
        }
    }
}
