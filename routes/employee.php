<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Faq\FaqController;
use App\Http\Controllers\API\Car\CarController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Home\HomeController;
use App\Http\Controllers\API\Leave\LeaveController;
use App\Http\Controllers\API\Report\ReportController;
use App\Http\Controllers\API\Car\ManagerCarController;
use App\Http\Controllers\API\Meeting\MeetingController;
use App\Http\Controllers\API\Profile\ProfileController;
use App\Http\Controllers\API\Leave\ManagerLeaveController;
use App\Http\Controllers\API\Deduction\DeductionController;
use App\Http\Controllers\API\Report\ManagerReportController;
use App\Http\Controllers\API\Attendence\AttendanceController;
use App\Http\Controllers\API\Meeting\ManagerMeetingController;
use App\Http\Controllers\API\Deduction\ManagerDeductionController;


Route::post('login'          , [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::middleware(['auth.employee'])->group(function () {
    Route::post('logout'         , [AuthController::class, 'logout']);

    // Home screen route
    Route::get('home-screen',   [HomeController::class, 'homeScreen']);

    // Profile routes
    Route::get('profile',       [ProfileController::class, 'getProfile']);
    Route::post('report-issue', [ProfileController::class, 'reportAnIssue']);

    // Attendance routes
    Route::post('/attendance',  [AttendanceController::class, 'attendance']);
    Route::get('/attendances',  [AttendanceController::class, 'attendanceHistory']);


    // Employee report routes
    Route::get('reports',                    [ReportController::class, 'index']);
    Route::get('reports/{id}',               [ReportController::class, 'show']);
    Route::get('unconfirmed-reports',        [ReportController::class, 'unconfirmedReports']);
    Route::post('daily-report',              [ReportController::class, 'storeDailyReport']);
    Route::get('today-report',               [ReportController::class, 'getTodayReport']);

    // Leaves routes
    Route::get('leaves',        [LeaveController::class, 'index']);
    Route::post('leaves',       [LeaveController::class, 'store']);
    Route::get('statistics',    [LeaveController::class, 'statistics']);

    // Faq routes
    Route::get('faqs',          [FaqController::class, 'index']);

    // Employee meeting routes
    Route::get('my-meetings',   [MeetingController::class, 'index']);

    // Employee Deduction routes
    Route::get('my-deductions', [DeductionController::class, 'index']);

    // Employee Cars routes
    Route::get('my-car', [CarController::class, 'myCar']);
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
    Route::get('/confirmed-reports'     ,[ManagerReportController::class, 'confirmedReports']);
    Route::get('/all-reports'           ,[ManagerReportController::class, 'allReports']);
    Route::put('/daily-reports/{id}'    ,[ManagerReportController::class, 'update']);
    Route::post('/confirm-report/{id}'  ,[ManagerReportController::class, 'confirmReport']);

    // Manager Deduction routes
    Route::get('deductions' ,     [ManagerDeductionController::class, 'index']);
    Route::post('deductions',     [ManagerDeductionController::class, 'store']);

    // Manager Car routes
    Route::get('cars'         , [ManagerCarController::class, 'index']);
    Route::get('cars/{car}'   , [ManagerCarController::class, 'show']);
    Route::post('cars'        , [ManagerCarController::class, 'store']);
    Route::put('cars/{car}'   , [ManagerCarController::class, 'update']);
    Route::delete('cars/{car}', [ManagerCarController::class, 'destroy']);
});


