<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Employee\AuthController;
use App\Http\Controllers\API\Employee\ReportController;
use App\Http\Controllers\API\Employee\ProfileController;
use App\Http\Controllers\API\Employee\AttendanceController;
use App\Http\Controllers\API\Manager\EmployeeReportController;

Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth.employee'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Profile routes
    Route::get('profile',       [ProfileController::class, 'getProfile']);
    Route::post('report-issue', [ProfileController::class, 'reportAnIssue']);
    
    // Attendance routes
    Route::post('/attendance',  [AttendanceController::class, 'attendance']);

    
    // Employee report routes
    Route::get('reports',       [ReportController::class, 'index']);
    Route::get('reports/{id}',  [ReportController::class, 'show']);
    Route::post('reports',      [ReportController::class, 'store']);

    // Manager report routes
    Route::get('/employees-reports',     [EmployeeReportController::class, 'employeeReports']);
    Route::get('/employees-reports/{id}',[EmployeeReportController::class, 'show']);
    Route::put('/reports/{id}',          [EmployeeReportController::class, 'update']);
    Route::post('/confirm-report/{id}',  [EmployeeReportController::class, 'confirmReport']);
});





