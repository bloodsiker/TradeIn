<?php

namespace App\Providers;

use App\Repositories\BuybackRequestRepository;
use App\Repositories\Interfaces\BuybackRequestRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BuybackRequestRepositoryInterface::class,
            BuybackRequestRepository::class
        );
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
