<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\EmployeesController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout',[AuthController::class, 'logout']);

    // Employees Routes
    Route::get('managers',              [EmployeesController::class, 'managers']);
    Route::post('add-employee',         [EmployeesController::class, 'AddEmployee']);
    Route::put('employees/{employee}',   [EmployeesController::class, 'updateEmployee']);
    Route::delete('employee/{employee}',[EmployeesController::class, 'deleteEmployee']);
    Route::get('all-employees',         [EmployeesController::class, 'allEmployees']);
    Route::get('employees/{employee}',   [EmployeesController::class, 'showEmployee']);
   // Route::put('change-password/{employee}', [EmployeesController::class, 'changeEmployeePassword']);
});

