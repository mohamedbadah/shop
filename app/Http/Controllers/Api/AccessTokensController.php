<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|string|min:8|max:18',
            'device_name'=>'string|max:225',
            'abillities'=>'nullable|array'
        ]);
        $user=User::where("email",$request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
          $device_name=$request->post("device_name",$request->userAgent());
          $token=$user->createToken($device_name,$request->post("abillities"));
          return response()->json([
          'code'=>1,
          'token'=>$token->plainTextToken,
          'user'=>$user
          ],201);
        }
        return response()->json([
            'code'=>0,
            'message'=>'invalid credntial',
        ],401);
    }
    public function destroy($token=null){
        $user=Auth::guard("sanctum")->user();
        if(null===$token){
            // $user->currentAccessToken()->delete();
            $user->tokens()->delete();
        }
        $personalAccessToken=PersonalAccessToken::findToken($token);
        if($user->id==$personalAccessToken->tokenable_id  && get_class($user)==$personalAccessToken->tokenable_type){
            $personalAccessToken->delete();
        }
        // Revoke all token
        // $user->token()->delete();
    }
}
