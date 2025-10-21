<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Employee\src\Http\Controllers\EmployeeController;
use Modules\Admin\Employee\src\Http\Controllers\AuthController;
Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function() {
    Route::get('/employees', [EmployeeController::class, 'index']);

    Route::get('/employee/{id}', [EmployeeController::class, 'show']);

    Route::delete('/employee', [EmployeeController::class, 'delete']);

    Route::delete('/employee/force/{id}', [EmployeeController::class, 'forceDelete']);

    Route::get('/employees/force', [EmployeeController::class, 'indexForce']);

    Route::patch('/employee/restore/{id}', [EmployeeController::class, 'restore']);

    Route::post('/employee', [EmployeeController::class, 'create']);

    Route::put('/employee/{id}', [EmployeeController::class, 'update']);

    Route::patch('/employee/{id}', [EmployeeController::class, 'update']);

    Route::get('/employees_name', [EmployeeController::class, 'findEmployeeName']);

    Route::get('/positions', [EmployeeController::class, 'getPosition']);

    Route::get('/grants', [EmployeeController::class, 'getGrants']);

    Route::get('/contrasts', [EmployeeController::class, 'getContrasts']);

    Route::get('/work_shifts', [EmployeeController::class, 'getWorkShifts']);

    Route::get('/departments', [EmployeeController::class, 'getDepartments']);

});

Route::prefix('admin/auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class,'logout'])->middleware('jwt.cookie.employee');
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.cookie.employee');
});
