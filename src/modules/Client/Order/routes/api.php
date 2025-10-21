<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Order\src\Http\Controllers\OrderController;
use Modules\Client\Order\src\Http\Controllers\MoneyPay;

Route::post('/order', [OrderController::class, 'create'])->middleware('jwt.cookie.user');

Route::get('/orders', [OrderController::class, 'index'])->middleware('jwt.cookie.user');

Route::get('/order/{code}', [OrderController::class, 'show'])->middleware('jwt.cookie.user');

Route::get('/order_find', [OrderController::class, 'findOrderCode'])->middleware('jwt.cookie.user');

Route::post('/add_order_pending', [OrderController::class, 'createOrderPending'])->middleware('jwt.cookie.user');

Route::post('/order/auto-pay', [OrderController::class, 'payOrder']);

Route::get('/order_check_pay/{code}', [OrderController::class, 'orderCheckPay'])->middleware('jwt.cookie.user');
