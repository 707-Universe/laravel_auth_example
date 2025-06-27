<?php

namespace App\Providers;

use App\Services\V1\EmailActivationTokenService;
use App\Services\V1\EmailActivationTokenServiceImpl;
use App\Services\V1\UserService;
use App\Services\V1\UserServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(EmailActivationTokenService::class, EmailActivationTokenServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
