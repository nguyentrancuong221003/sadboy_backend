<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Comment\src\Http\Controllers\CommentController;

Route::post('/comment', [CommentController::class, 'create'])->middleware('jwt.cookie.user');
