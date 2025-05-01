<?php

namespace App\Providers;

use App\Interfaces\Admin\Post\AdminCreatePostInterface;
use App\Interfaces\Admin\Post\AdminDeletedPostInterface;
use App\Interfaces\Admin\Post\AdminListenPostsInterface;
use App\Interfaces\Admin\Post\AdminUpdatedPostInterface;

use App\Interfaces\Auth\AdminLoginInterface\AdminLoginInterface;
use App\Interfaces\Auth\UserLoginInterface\UserLoginInterface;
use App\Interfaces\Auth\UserLoginInterface\UserRegisterInterface;
use App\Interfaces\User\Post\PostDeleteInterface;
use App\Interfaces\User\Post\PostListenInterface;
use App\Interfaces\User\Post\PostUpdateInterface;
use App\Interfaces\User\Post\PostCreateInterface;
use App\Services\Admin\Post\AdminCreatePostService;
use App\Services\Admin\Post\AdminDeletePostService;
use App\Services\Admin\Post\AdminListenPostsService;
use App\Services\Admin\Post\AdminUpdatePostService;
use App\Services\Auth\AdminLoginServices\AdminLoginService;
use App\Services\Auth\UserLoginServices\UserLoginAndLogoutService;
use App\Services\Auth\UserLoginServices\UserRegisterService;
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


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
