<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Order\src\Http\Controllers\OrderController;

Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function() {
    Route::get('/orders', [OrderController::class, 'index']);

    Route::delete('/order', [OrderController::class, 'destroy']);

    Route::patch('/order/confirm', [OrderController::class, 'confirm']);

    Route::get('/order/{id}',[OrderController::class, 'show']);

    Route::put('/order/{id}', [OrderController::class, 'update']);

    Route::patch('/order/{id}', [OrderController::class, 'update']);

    Route::get('/orders/force', [OrderController::class, 'indexForce']);

    Route::delete('/order/force/{id}', [OrderController::class, 'forceDelete']);

    Route::patch('/order/restore/{id}', [OrderController::class, 'restore']);

    Route::get('/orders_code', [OrderController::class, 'findOrderCode']);
});

