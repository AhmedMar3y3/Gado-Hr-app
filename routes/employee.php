<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Employee\AuthController;
use App\Http\Controllers\API\Employee\ReportController;
use App\Http\Controllers\API\Employee\ProfileController;
use App\Http\Controllers\API\Employee\AttendanceController;
use App\Http\Controllers\API\Manager\EmployeeReportController;
use App\Http\Controllers\API\Manager\MeetingController;
use App\Http\Controllers\API\Employee\MeetingController as EmployeeMeetingController;
use App\Http\Controllers\API\Manager\EmployeesController;

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
    
    // Employee meeting routes
    Route::get('my-meetings',            [EmployeeMeetingController::class, 'index']);
    
    // Manager meeting routes
});

Route::middleware(['auth.employee','role:1'])->group(function () {
    Route::get('meetings',               [MeetingController::class, 'index']);
    Route::post('meetings',              [MeetingController::class, 'store']);
    Route::get('employees',              [EmployeesController::class, 'employees']);
});



