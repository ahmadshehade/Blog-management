<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\PostController;

Route::post('register/user', [UserAuthController::class, 'register']);
Route::post('login/user', [UserAuthController::class, 'login']);

Route::middleware('auth:api')->post('logout/user', [UserAuthController::class, 'logout']);

################################################ Posts ######################################################

Route:: prefix('user')->middleware('auth:api')->group(function () {

    Route::post('make/post', [PostController::class, 'store']);

    Route::post('update/post/{id}', [PostController::class, 'update'])
        ->middleware('postOperation');

    Route::delete('delete/post/{id}', [PostController::class, 'destroy'])
        ->middleware('postOperation');

    Route::get('get/all/posts', [PostController::class, 'index']);

    Route::get('get/my/posts', [PostController::class, 'show']);

    Route::get('get/post/{id}', [PostController::class, 'getPost']);

 ################################################ Comments ######################################################

    Route::post('create/comment',[CommentController::class,'store']);

    Route::get('get/comments/to/post/{id}',[CommentController::class,'getPotComment'])
    ->middleware('postOperation');

    Route::put('update/comment/{id}',[CommentController::class,'update']);

    Route::delete('delete/comment/{id}',[CommentController::class,'destroy']);
   



});

require_once __DIR__ . '/admin.php';
