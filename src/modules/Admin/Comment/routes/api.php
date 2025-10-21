<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Comment\src\Http\Controllers\CommentController;
Route::prefix('admin')->middleware('jwt.cookie.employee')->group(function() {

    Route::get('/comments', [CommentController::class, 'index']);

    Route::get('/comments_code', [CommentController::class, 'findCommentCode']);

    Route::delete('/comments', [CommentController::class, 'delete']);

    Route::get('/comment/{id}', [CommentController::class, 'show']);

    Route::get('/comments/force', [CommentController::class, 'indexForce']);

    Route::delete('/comment/force/{id}', [CommentController::class, 'forceDelete']);

    Route::patch('/comment/restore/{id}', [CommentController::class, 'restore']);
});

