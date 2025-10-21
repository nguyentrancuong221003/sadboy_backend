<?php

use Illuminate\Support\Facades\Route;

Route::get('/Product', function () {
    //return 'Đây là module Product22222';
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

