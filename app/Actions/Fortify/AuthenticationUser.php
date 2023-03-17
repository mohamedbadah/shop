<?php
namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthenticationUser{
    public function authenticate($request){
        $username=$request->post(config("fortify.username"));
        $password=$request->post("password");
        $user=Admin::where("email",$username)->orWhere("username",$username)
        ->orWhere("phone",$username)->first();
        if($user && Hash::check($password,$user->password)){
            return $user;
        }
        return false;
    }
}
?>