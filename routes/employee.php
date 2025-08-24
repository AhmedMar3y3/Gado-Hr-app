<?php

use App\Http\Controllers\API\Article\ArticleController;
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
use App\Http\Controllers\API\Employee\EmployeesController;
use App\Http\Controllers\API\Deduction\DeductionController;
use App\Http\Controllers\API\Report\ManagerReportController;
use App\Http\Controllers\API\Attendence\AttendanceController;
use App\Http\Controllers\API\Meeting\ManagerMeetingController;
use App\Http\Controllers\API\Deduction\ManagerDeductionController;
use App\Http\Controllers\API\Advance\AdvanceController;
use App\Http\Controllers\API\Advance\ManagerAdvanceController;
use App\Http\Controllers\API\EmployeeRequests\RequestsController;

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

    // Faq routes
    Route::get('faqs',          [FaqController::class, 'index']);

    // Employee meeting routes
    Route::get('my-meetings',   [MeetingController::class, 'index']);

    // Employee Deduction routes
    Route::get('my-deductions', [DeductionController::class, 'index']);

    // Employee Cars routes
    Route::get('my-car', [CarController::class, 'myCar']);

    // Employee Advance routes
    Route::get('advances' , [AdvanceController::class, 'index']);
    Route::post('advances', [AdvanceController::class, 'store']);

    // Articles routes
    Route::get('articles', [ArticleController::class, 'index']);
});

// Manager routes
Route::middleware(['auth.employee', 'role:1'])->group(function () {

    // Meeting routes
    Route::get('meetings',               [ManagerMeetingController::class, 'index']);
    Route::post('meetings',              [ManagerMeetingController::class, 'store']);
    Route::get('employees',              [ManagerMeetingController::class, 'employees']);

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
    
    // Leave routes
    Route::get('leave-details/{leave}' , [ManagerLeaveController::class, 'leaveDetails']);
    Route::put('approve-leave/{leave}' , [ManagerLeaveController::class, 'approveLeave']);
    Route::put('reject-leave/{leave}'  , [ManagerLeaveController::class, 'rejectLeave']);

    // Manager Advance routes
    Route::get('advance-details/{advance}', [ManagerAdvanceController::class, 'advanceDetails']);
    Route::put('approve-advance/{advance}', [ManagerAdvanceController::class, 'approveAdvance']);
    Route::put('reject-advance/{advance}' , [ManagerAdvanceController::class, 'rejectAdvance']);
    
    // Manager Requests routes (not used but could be)
    Route::get('employee-advances', [RequestsController::class, 'employeeAdvances']);
    Route::get('employee-requests', [RequestsController::class, 'employeeRequests']);
    Route::get('request-details/{type}/{id}', [RequestsController::class, 'requestDetails']);

    // Employee routes
    Route::get('manager-employees'     , [EmployeesController::class, 'getEmployees']);
    Route::get('manager-employees/{id}', [EmployeesController::class, 'showEmployeeDetails']);

    // Articles routes
    Route::post('articles', [ArticleController::class, 'store']);
});


