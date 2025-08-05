<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\LoginAdminRequest;
use App\Http\Requests\API\Admin\Auth\RegisterAdminRequest;
use App\Http\Resources\API\Admin\Auth\AdminResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function register(RegisterAdminRequest $request)
    {
        if (User::exists()) {
            return $this->failureResponse('يوجد ادمن مسجل مسبقا');
        }
        User::create($request->validated());

        return $this->successResponse('تم تسجيل الادمن بنجاح');
    }

    public function login(LoginAdminRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->failureResponse('بيانات الدخول غير صحيحة');
        }

        $token = $user->login();

        return $this->successWithDataResponse(AdminResource::make($user)->setToken($token));
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse('تم تسجيل الخروج بنجاح');
    }
}
