<?php

namespace App\Providers;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\AdminRepository;
use App\Repositories\User\AdminInterface;


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
            UserInterface::class,
            ProductInterface::class, 
            AdminInterface::class, 

        ];
    }
}
