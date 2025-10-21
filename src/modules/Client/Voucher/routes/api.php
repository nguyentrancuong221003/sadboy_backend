<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Voucher\src\Http\Controllers\VoucherController;

Route::get('/voucher', [VoucherController::class, 'show'])->middleware('jwt.cookie.user');
