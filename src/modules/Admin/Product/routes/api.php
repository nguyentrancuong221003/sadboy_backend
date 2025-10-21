<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Product\src\Http\Controllers\ProductController;

Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function() {

    Route::get('/products', [ProductController::class, 'index']);

    Route::delete('/product',[ProductController::class, 'destroy']);

    Route::get('/products_name', [ProductController::class, 'findProductName']);

    Route::get('/categories', [ProductController::class, 'getCategories']);

    Route::post('/product', [ProductController::class, 'create']);

    Route::get('/product/{id}', [ProductController::class, 'show']);

    Route::put('/product/{id}', [ProductController::class, 'update']);

    Route::patch('/product/{id}', [ProductController::class, 'update']);

    Route::get('/list_product_supply', [ProductController::class, 'productSupply']);

    Route::get('/product_supply_name', [ProductController::class, 'findProductSupply']);

    Route::post('/goodsReceipt', [ProductController::class, 'addGoodsReceipt']);

    Route::get('/products/force', [ProductController::class, 'indexForce']);

    Route::delete('/product/force/{id}', [ProductController::class, 'forceDelete']);

    Route::patch('/product/restore/{id}', [ProductController::class, 'restore']);
});

//
