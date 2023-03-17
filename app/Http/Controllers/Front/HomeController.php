<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Scopes\StoreScope;

class HomeController extends Controller
{
    public function index(){
        $products=Product::withoutGlobalScope("store")->with("category")->active()->limit(8)->get();
        // dd($products);
        return view("front.home",compact("products"));
    }
}
