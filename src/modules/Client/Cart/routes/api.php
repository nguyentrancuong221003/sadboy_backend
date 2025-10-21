<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Cart\src\Http\Controllers\CartController;

Route::get('/carts', [CartController::class, 'index'])->middleware('jwt.cookie.user');

Route::delete('/cart', [CartController::class, 'destroy'])->middleware('jwt.cookie.user');

Route::post('/cart', [CartController::class, 'create'])->middleware('jwt.cookie.user');
