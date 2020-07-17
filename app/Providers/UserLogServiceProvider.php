<?php

namespace App\Providers;

use App\Services\UserLogService;
use Illuminate\Support\ServiceProvider;

class UserLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('UserLog',function(){

            return new UserLogService();

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
