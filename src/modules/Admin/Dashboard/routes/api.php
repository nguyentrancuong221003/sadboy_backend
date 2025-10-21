<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Dashboard\src\Http\Controllers\DashboardController;

Route::get('/admin/dashboards', [DashboardController::class, 'index']);
