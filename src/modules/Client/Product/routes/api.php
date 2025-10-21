<?php

use Illuminate\Support\Facades\Route;

use Modules\Client\Product\src\Http\Controllers\ProductController;

Route::get('/categories', [ProductController::class, 'getCategories']);

Route::get('/productsType', [ProductController::class, 'ProductsType']);

Route::get('/productPopular', [ProductController::class, 'ProductsPopular']);

Route::get('/product', [ProductController::class, 'show']);

Route::get('/add_comment_product', [ProductController::class, 'addComment']);

Route::get('/product_search', [ProductController::class, 'findName']);

Route::get('/products', [ProductController::class, 'index']);
