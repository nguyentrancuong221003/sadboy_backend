<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Stock\src\Http\Controllers\StockController;
Route::prefix('admin')->group(function() {

    Route::get('/stocks', [StockController::class, 'index']);
    
});
