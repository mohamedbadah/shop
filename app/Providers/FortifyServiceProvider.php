<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\AuthenticationUser;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request=request();
        if($request->is("admin/*")){
            Config::set('fortify.guard','admin');
            // Config::set("fortify.home","dashboard/index");
            Config::set("fortify.passwords","admins");
            Config::set("fortify.prefix","admin");

        }
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
               if($request->user("admin")){
                 return redirect()->intended("dashboard/index");
               }else{
                return redirect()->intended("/");
               }
            }
        });
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                // dd($request->all());
                if($request->admin){
                    return redirect("admin/login");
                }
               return redirect("login");
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        // Fortify::loginView("auth.login");
        Fortify::viewPrefix('auth.');
        if(Config::get("fortify.guard")=="admin"){
            Fortify::authenticateUsing([new AuthenticationUser,"authenticate"]);
            Fortify::viewPrefix("auth.");
        }else{
            Fortify::viewPrefix("front.auth.");


        }
        // Fortify::registerView('auth.register');
        // Fortify::loginView(function(){
        //  if(config('fortify.guard')=="admin"){
        //      return view("auth.login");
        //  }
        //  return view("front.auth.login");
        // });
    }
}
