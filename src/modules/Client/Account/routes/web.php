<?php

use Illuminate\Support\Facades\Route;

use Modules\Client\Account\src\Http\Controllers\LoginSocialiteController;
Route::get('auth/google/redirect', [LoginSocialiteController::class, 'redirect'])->middleware('web');

Route::get('auth/google/callback', [LoginSocialiteController::class, 'callback'])->middleware('web');

