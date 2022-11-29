<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BrandRepositoryInterface;
use App\Repositories\BrandRepository;
use App\Interfaces\OutletRepositoryInterface;
use App\Repositories\OutletRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;

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
            BrandRepositoryInterface::class,
            BrandRepository::class
        );
        $this->app->bind(
            OutletRepositoryInterface::class,
            OutletRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
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
