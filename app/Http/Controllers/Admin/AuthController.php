<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Auth\LoginAdminRequest;

class AuthController extends Controller
{
    public function loadLoginPage()
    {
        return view('Admin.login');
    }

    public function loginUser(LoginAdminRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return back()->withErrors(['error' => 'خطأ في كلمة المرور او المستخدم'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function dashboard()
    {
        return view('Admin.dashboard');
    }
}
