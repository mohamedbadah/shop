<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->app->bind("abilities",function(){
            return include base_path("data/ability.php");
        });
    }
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function($user,$ability){
          if($user->super_admin){
            return true;
          }
        });
        foreach($this->app->make("abilities") as $code=>$label){
            Gate::define($code,function($user) use ($code){
                  return $user->hasAbilities($code);
            });
        }
        // Gate::define("category.view",function($user){
        //     return true;
        // });
        // Gate::define("category.update",function(){
        //     return true;
        // });
        // Gate::define("category.create",function($user){
        //     return true;
        // });
        // Gate::define("category.destroy",function($user){
        //     return true;
        // });
        //
    }
}
