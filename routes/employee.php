<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Employee\AuthController;
use App\Http\Controllers\API\Employee\ProfileController;


Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth.employee'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Profile routes
    Route::get('profile',       [ProfileController::class, 'getProfile']);
    Route::post('report-issue', [ProfileController::class, 'reportAnIssue']);
    
});
