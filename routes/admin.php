<?php

use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;


Route::post('admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::post('admin/logout', [AdminAuthController::class, 'logout']);

################################################## Posts ##################################

    Route::prefix('admin')->group(function () {

        Route::post('make/post', [PostController::class, 'store']);
        Route::post('change/published/{id}', [PostController::class, 'update']);
        Route::get('get/post/{id}', [PostController::class, 'show']);
        Route::get('get/all/posts', [PostController::class, 'index']);
        Route::get('get/my/posts', [PostController::class, 'getMyPosts']);
        Route::delete('delete/post/{id}', [PostController::class, 'destroy']);

    });

});






