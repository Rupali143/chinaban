<?php

namespace App\Providers;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserInterface;

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
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
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

    public function provides() {
        return [
            AdminInterface::class,
            UserInterface::class,
            ProductInterface::class, 
        ];
    }
}
