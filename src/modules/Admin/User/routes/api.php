<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\User\src\Http\Controllers\UserController;
use Modules\Admin\User\src\Http\Controllers\AuthController;

Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/user/{id}', [UserController::class, 'show']);

    Route::put('/user/{id}', [UserController::class, 'update']);

    Route::patch('/user/{id}', [UserController::class, 'update']);

    Route::delete('/user', [UserController::class, 'destroy']);

    Route::get('/users_name', [UserController::class, 'findUserName']);

    Route::get('/users/force', [UserController::class, 'indexForce']);

    Route::delete('/user/force/{id}', [UserController::class, 'forceDelete']);

    Route::patch('/user/restore/{id}', [UserController::class, 'restore']);
});



