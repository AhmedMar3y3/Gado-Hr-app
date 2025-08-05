<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Faq\FaqController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Leave\LeaveController;
use App\Http\Controllers\API\Report\ReportController;
use App\Http\Controllers\API\Profile\ProfileController;
use App\Http\Controllers\API\Meeting\MeetingController;
use App\Http\Controllers\API\Leave\ManagerLeaveController;
use App\Http\Controllers\API\Report\ManagerReportController;
use App\Http\Controllers\API\Attendence\AttendanceController;
use App\Http\Controllers\API\Meeting\ManagerMeetingController;


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

    // Employee meeting routes
    Route::get('my-meetings',   [MeetingController::class, 'index']);
});

// Manager routes
Route::middleware(['auth.employee', 'role:1'])->group(function () {

    // Meeting routes
    Route::get('meetings',               [ManagerMeetingController::class, 'index']);
    Route::post('meetings',              [ManagerMeetingController::class, 'store']);
    Route::get('employees',              [ManagerMeetingController::class, 'employees']);

    // Leave routes
    Route::get('employee-leaves',        [ManagerLeaveController::class, 'employeeLeaves']);
    Route::get('leave-details/{id}',     [ManagerLeaveController::class, 'leaveDetails']);
    Route::put('accept-leave/{id}',      [ManagerLeaveController::class, 'acceptLeave']);
    Route::put('reject-leave/{id}',      [ManagerLeaveController::class, 'rejectLeave']);

    // Manager report routes
    Route::get('/employees-reports'     ,[ManagerReportController::class, 'employeeReports']);
    Route::get('/employees-reports/{id}',[ManagerReportController::class, 'show']);
    Route::put('/reports/{id}'          ,[ManagerReportController::class, 'update']);
    Route::post('/confirm-report/{id}'  ,[ManagerReportController::class, 'confirmReport']);
});
