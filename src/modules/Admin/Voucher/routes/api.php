<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Voucher\src\Http\Controllers\VoucherController;

Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function() {

    Route::get('/vouchers', [VoucherController::class, 'index']);

    Route::delete('/voucher', [VoucherController::class, 'destroy']);

    Route::post('/voucher', [VoucherController::class, 'create']);

    Route::get('/vouchers_code', [VoucherController::class, 'findVoucherCode']);

    Route::get('/voucher/{id}', [VoucherController::class, 'show']);

    Route::get('/vouchers/force', [VoucherController::class, 'indexForce']);

    Route::delete('/voucher/force/{id}', [VoucherController::class, 'forceDelete']);

    Route::patch('/voucher/restore/{id}', [VoucherController::class, 'restore']);

    Route::patch('/voucher/{id}', [VoucherController::class, 'update']);
});

