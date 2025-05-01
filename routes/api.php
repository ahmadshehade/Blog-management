<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\User\PostController;

Route::post('register/user', [UserAuthController::class, 'register']);
Route::post('login/user', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('logout/user', [UserAuthController::class, 'logout']);

################################################ Posts ######################################################

Route:: prefix('user')->middleware('auth:api')->group(function () {

    Route::post('make/post', [PostController::class, 'store']);

    Route::post('update/post/{id}', [PostController::class, 'update'])
        ->middleware('postOperation');

    Route::delete('delete/post/{id}', [PostController::class, 'destroy'])
        ->middleware('postOperation');

    Route::get('get/all/posts', [PostController::class, 'index']);

    Route::get('get/my/posts', [PostController::class, 'show']);

    Route::get('get/post/{id}',[PostController::class,'getPost']);

});

require_once __DIR__ . '/admin.php';
