<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Provide\src\Http\Controllers\ProvideController;
Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function () {

    Route::get('/provides', [ProvideController::class, 'index']);

    Route::get('/provides_name', [ProvideController::class, 'findProvideName']);

    Route::delete('/provide', [ProvideController::class, 'delete']);

    Route::post('/provide', [ProvideController::class, 'create']);

    Route::get('/provide/{id}', [ProvideController::class, 'show']);

    Route::get('/provide/{id}/orders', [ProvideController::class, 'loadOrder']);

    Route::put('/provide/{id}', [ProvideController::class, 'update']);

    Route::patch('/provide/{id}', [ProvideController::class, 'update']);

    Route::get('/provides/force', [ProvideController::class, 'indexForce']);

    Route::delete('/provide/force/{id}', [ProvideController::class, 'forceDelete']);

    Route::patch('/provide/restore/{id}', [ProvideController::class, 'restore']);
});
