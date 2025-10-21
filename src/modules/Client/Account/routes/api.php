<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Account\src\Http\Controllers\AuthController;
use Modules\Client\Account\src\Http\Controllers\UserController;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class,'logout'])->middleware('jwt.cookie.user');

    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.cookie.user');

});

Route::prefix('user')->group(function() {
    Route::post('/register', [UserController::class, 'create']);

    Route::put('/edit', [UserController::class, 'update'])->middleware('jwt.cookie.user');

    Route::patch('/edit', [UserController::class, 'update'])->middleware('jwt.cookie.user');

    Route::get('/vouchers', [UserController::class, 'getUserVouchers'])->middleware('jwt.cookie.user');
});



