<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Employee\AuthController;
use App\Http\Controllers\API\Employee\ReportController;
use App\Http\Controllers\API\Employee\ProfileController;
use App\Http\Controllers\API\Employee\AttendanceController;
use App\Http\Controllers\API\Manager\EmployeeReportController;
use App\Http\Controllers\API\Manager\MeetingController;
use App\Http\Controllers\API\Manager\EmployeesController;
use App\Http\Controllers\API\Employee\LeaveController;
use App\Http\Controllers\API\Employee\FaqController;
use App\Http\Controllers\API\Manager\EmployeeLeaveController;
use App\Http\Controllers\API\Employee\MeetingController as EmployeeMeetingController;

//TODO: use the middleware of the role for all the manager routes and remove the check from the model

Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth.employee'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    
    // Profile routes
    Route::get('profile',       [ProfileController::class, 'getProfile']);
    Route::post('report-issue', [ProfileController::class, 'reportAnIssue']);
    
    // Attendance routes
    Route::post('/attendance',  [AttendanceController::class, 'attendance']);
    Route::get('/attendances',  [AttendanceController::class, 'attendanceHistory']);
    Route::get('/departures',   [AttendanceController::class, 'departureHistory']);
    
    
    // Employee report routes
    Route::get('reports',       [ReportController::class, 'index']);
    Route::get('reports/{id}',  [ReportController::class, 'show']);
    Route::post('reports',      [ReportController::class, 'store']);

    // Leaves routes
    Route::get('leaves',        [LeaveController::class, 'index']);
    Route::post('leaves',       [LeaveController::class, 'store']);
    Route::get('statistics',    [LeaveController::class, 'statistics']);

    // Faq routes
    Route::get('faqs',          [FaqController::class, 'index']);
    
    // Manager report routes
    Route::get('/employees-reports',     [EmployeeReportController::class, 'employeeReports']);
    Route::get('/employees-reports/{id}',[EmployeeReportController::class, 'show']);
    Route::put('/reports/{id}',          [EmployeeReportController::class, 'update']);
    Route::post('/confirm-report/{id}',  [EmployeeReportController::class, 'confirmReport']);
    
    // Employee meeting routes
    Route::get('my-meetings',            [EmployeeMeetingController::class, 'index']);
    
});

// Manager routes
Route::middleware(['auth.employee','role:1'])->group(function () {

    // Meeting routes
    Route::get('meetings',               [MeetingController::class, 'index']);
    Route::post('meetings',              [MeetingController::class, 'store']);
    Route::get('employees',              [EmployeesController::class, 'employees']);

    // Leave routes
    Route::get('employee-leaves',        [EmployeeLeaveController::class, 'employeeLeaves']);
    Route::get('leave-details/{id}',     [EmployeeLeaveController::class, 'leaveDetails']);
    Route::put('accept-leave/{id}',      [EmployeeLeaveController::class, 'acceptLeave']);
    Route::put('reject-leave/{id}',      [EmployeeLeaveController::class, 'rejectLeave']);
});



