<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Cash_book\src\Http\Controllers\CashBookController;

Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function() {

    Route::get('/goodsReceipts', [CashBookController::class, 'index']);

    Route::get('/goodsReceipts_code', [CashBookController::class, 'GoodsReceiptsCode']);

    Route::get('/goodsReceipt/{id}', [CashBookController::class, 'show']);

    Route::put('/goodsReceipt/{id}', [CashBookController::class, 'update']);

    Route::patch('/goodsReceipt/{id}', [CashBookController::class, 'update']);

    Route::get('/debt_provide', [CashBookController::class, 'indexDebtProvide']);

    Route::get('/income_spend', [CashBookController::class, 'indexIncomeSpend']);

    Route::get('/findIncomeSpend', [CashBookController::class, 'IncomeSpendCode']);

    Route::get('/order_success', [CashBookController::class, 'orderSuccess']);

    Route::post('/addBill', [CashBookController::class, 'createBill']);
});

