<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Interfaces\CompanyRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(AuthRepositoryInterface::class,AuthRepository::class);
         $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
         $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
         $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
         $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
