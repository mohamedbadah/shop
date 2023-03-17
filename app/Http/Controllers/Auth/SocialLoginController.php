<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider){
        try{
            $provider_user=Socialite::driver($provider)->user();
            $user=User::where([
                "provider_id"=>$provider_user->user["id"],
                "provider"=>$provider
            ]
                )->first();
            if(!$user){
                $user=User::create([
                    "provider_id"=>$provider_user->user["id"],
                    "email"=>$provider_user->user["email"],
                    "name"=>$provider_user->user["name"],
                    "provider"=>$provider,
                    "provider_token"=>$provider_user->token,
                    "password"=>Hash::make(Str::random(8))
                ]);
            }
        Auth::login($user);
        return redirect()->route("home");

        }catch(Exception $e){
           return redirect()->route("login")->withErrors(["email"=>$e->getMessage()]);
        }

    }

    public function index($provider){
        $user=Auth::user();
        // dd($user->provider_token);
        $user_provider=Socialite::driver($provider)->userFromToken($user->provider_token); 
        dd($user_provider);
    }
}
