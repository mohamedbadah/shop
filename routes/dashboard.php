<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\dashboard\CategoryContoller;
use App\Http\Controllers\Dashboard\ImportedProductsController;
use App\Http\Controllers\dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
// "auth.type:admin,super_admin",'verified'
Route::prefix('dashboard')->middleware(["auth:admin,web"])->as("admin.")->group(function(){
Route::get("index",[DashboardController::class,'index'])->name("dashboard");
Route::get("/category/trash",[CategoryContoller::class,"trash"])->name("category.trash");
Route::put("category/{category}/restore",[CategoryContoller::class,"restore"])->name("category.restore");
Route::delete("category/{category}/forceDelete",[CategoryContoller::class,"forceDelete"])->name("category.forceDelete");
Route::resource("category",CategoryContoller::class);
Route::get("products/import",[ImportedProductsController::class,"create"])->name("products.imported");
Route::post("products/import",[ImportedProductsController::class,"store"]);
Route::resource("product",ProductController::class);
Route::resource("role",RoleController::class);
Route::resource("admin",AdminController::class);
Route::get("profile",[ProfileController::class,"edit"])->name("profile");
Route::patch("profile",[ProfileController::class,"update"])->name("update_profile");
});
?>