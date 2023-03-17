<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\DeliveryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware("auth:sanctum")->group(function(){
//     Route::delete("token/{token?}",[AccessTokensController::class,"destroy"]);
// });
Route::apiResource("products",ProductController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware("guest:sanctum")->group(function(){
Route::post("auth/login",[AccessTokensController::class,'store']);
});

Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class, 'destroy'])
    ->middleware('auth:sanctum');
    Route::get("p/{id}",function($id){
     $product=Product::where("id",$id)->first(); 
     return response()->json(['message'=>$product]);
    })->middleware("auth:sanctum");
Route::get("delivery/{delivery}",[DeliveryController::class,"show"]);
Route::put("delivery/{delivery}",[DeliveryController::class,"update"]);


