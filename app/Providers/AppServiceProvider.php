<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('manager', function ($app, array $config) {
            return new ManagerUserProvider($app['hash'], $config['model']);
        });

        Auth::provider('employee', function ($app, array $config) {
            return new EmployeeUserProvider($app['hash'], $config['model']);
        });
    }
}
