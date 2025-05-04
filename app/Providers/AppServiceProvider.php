<?php

namespace App\Providers;

use App\Interfaces\Admin\Comments\AdminCreateCommentInterface;
use App\Interfaces\Admin\Comments\AdminDeleteCommentInterface;
use App\Interfaces\Admin\Comments\AdminListenCommentInterface;
use App\Interfaces\Admin\Comments\AdminUpdateCommentInterface;
use App\Interfaces\Admin\Post\AdminCreatePostInterface;
use App\Interfaces\Admin\Post\AdminDeletedPostInterface;
use App\Interfaces\Admin\Post\AdminListenPostsInterface;
use App\Interfaces\Admin\Post\AdminUpdatedPostInterface;

use App\Interfaces\Auth\AdminLoginInterface\AdminLoginInterface;
use App\Interfaces\Auth\UserLoginInterface\UserLoginInterface;
use App\Interfaces\Auth\UserLoginInterface\UserRegisterInterface;
use App\Interfaces\User\Comments\CreateCommentInterface;
use App\Interfaces\User\Comments\DeleteCommentInterface;
use App\Interfaces\User\Comments\GetCommentsInterface;
use App\Interfaces\User\Comments\UpdateCommentInterface;
use App\Interfaces\User\Post\PostDeleteInterface;
use App\Interfaces\User\Post\PostListenInterface;
use App\Interfaces\User\Post\PostUpdateInterface;
use App\Interfaces\User\Post\PostCreateInterface;
use App\Services\Admin\Comments\AdminCreateCommentService;
use App\Services\Admin\Comments\AdminDeleteCommentService;
use App\Services\Admin\Comments\AdminListenCommentService;
use App\Services\Admin\Comments\AdminUpdateCommentService;
use App\Services\Admin\Post\AdminCreatePostService;
use App\Services\Admin\Post\AdminDeletePostService;
use App\Services\Admin\Post\AdminListenPostsService;
use App\Services\Admin\Post\AdminUpdatePostService;
use App\Services\Auth\AdminLoginServices\AdminLoginService;
use App\Services\Auth\UserLoginServices\UserLoginAndLogoutService;
use App\Services\Auth\UserLoginServices\UserRegisterService;
use App\Services\User\Comments\CreateCommentService;
use App\Services\User\Comments\DeleteCommentService;
use App\Services\User\Comments\GetCommentsService;
use App\Services\User\Comments\UpdateCommentService;
use App\Services\User\Post\PostCreateService;
use App\Services\User\Post\PostDeleteService;
use App\Services\User\Post\PostListenService;
use App\Services\User\Post\PostUpdateService;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRegisterInterface::class,UserRegisterService::class);
        $this->app->bind(UserLoginInterface::class,UserLoginAndLogoutService::class);
        $this->app->bind(AdminLoginInterface::class,AdminLoginService::class);
        ####################################### User Post #############################################
        $this->app->bind(PostListenInterface::class,PostListenService::class);
        $this->app->bind(PostCreateInterface::class,PostCreateService::class);
        $this->app->bind(PostUpdateInterface::class,PostUpdateService::class);
        $this->app->bind(PostDeleteInterface::class,PostDeleteService::class);
        ####################################### Admin Post #############################################
        $this->app->bind(AdminListenPostsInterface::class,AdminListenPostsService::class);
        $this->app->bind(AdminCreatePostInterface::class,AdminCreatePostService::class);
        $this->app->bind(AdminUpdatedPostInterface::class,AdminUpdatePostService::class);
        $this->app->bind(AdminDeletedPostInterface::class,AdminDeletePostService::class);
        ####################################### User Comment #############################################
        $this->app->bind(CreateCommentInterface::class,CreateCommentService::class);
        $this->app->bind(UpdateCommentInterface::class,UpdateCommentService::class);
        $this->app->bind(DeleteCommentInterface::class,DeleteCommentService::class);
        $this->app->bind(GetCommentsInterface::class,GetCommentsService::class);
         ####################################### Admin Comment #############################################
         $this->app->bind(AdminCreateCommentInterface::class,AdminCreateCommentService::class);
         $this->app->bind(AdminUpdateCommentInterface::class,AdminUpdateCommentService::class);
         $this->app->bind(AdminListenCommentInterface::class,AdminListenCommentService::class);
         $this->app->bind(AdminDeleteCommentInterface::class,AdminDeleteCommentService::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
