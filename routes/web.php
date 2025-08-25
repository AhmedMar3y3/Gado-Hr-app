<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

// public routes //
Route::get('/',            [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin',[AuthController::class, 'loginUser'])->name('loginUser');

// protected routes //
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard',[AuthController::class, 'dashboard'])->name('admin.dashboard');

});

