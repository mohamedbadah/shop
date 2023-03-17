<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\services\CurrencyConverter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\Front\PaymentsController;
use App\Models\Payment;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::group(["prefix"=>"{locale}"],function(){
    Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::get("/",[HomeController::class,"index"])->name("home");
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get("index",[DashboardController::class,'index'])->name("dashboard");
    //    Route::resource("product",ProductController::class);
       });
    Route::get("/products",[ProductsController::class,"show"])->name("products.index");
    Route::get("/products/{product:slug}",[ProductsController::class,"show"])->name("products.show");
    Route::resource("cart",CartController::class);
    Route::get("checkout",[CheckoutController::class,"index"])->name("checkout");
    Route::post("checkout",[CheckoutController::class,"checkout"]);
    Route::view('auth/user/2fa', 'front.auth.two-factor-auth');
    Route::post("convertCurrency",[CurrencyConverterController::class,"store"])->name("currency.store");
    Route::get("auth/{provider}/redirect",[SocialLoginController::class,"redirect"])->name("loginwithprovider");
    Route::get("auth/{provider}/callback",[SocialLoginController::class,"callback"])->name("callbackLogin");
    Route::get("auth/{provider}/index",[SocialLoginController::class,"index"]);
    Route::get("order/{order}/pay",[PaymentsController::class,"create"])->name("order.payment.create");

    Route::post("stripe/{order}/create/pay",[PaymentsController::class,"createPaymentIntent"])->name("stripe.paymentIntent.create");
    Route::get("order/{order}/pay/stripe/callback",[PaymentsController::class,"confirm"])->name("stripe.return");
    Route::get("delivery/{order}",[OrderController::class,"show"])->name("delivery.show");
    
    Route::post("check/paypal",function(){
        echo "hello mohamed";
    });
});

// });

// require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
