<?php

namespace App\Providers;

use App\Repository\Cart\CartRepository;
use App\Repository\Cart\CartRepositoryModel;
use Illuminate\Support\ServiceProvider;

class CartProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartRepository::class,function(){
             return new CartRepositoryModel();
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
