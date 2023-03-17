<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('filter',function($attribute,$value,$param){
            return !(in_array(strtolower($value),$param));
        },"the value is prohipted");
     JsonResource::withoutWrapping();
        Paginator::useBootstrapFour();
        // Paginator::defaultView("paginator.pag");
        App::setlocale(request("locale","en"));
    }
}
