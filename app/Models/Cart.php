<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    public $incrementing=false;
    protected $guarded=[];
    protected static function booted(){
        // static::creating(function(Cart $cart){
        //     $cart->id=Str::uuid();
        // });
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id',function($query){
        $query->where("cookie_user","=",Cart::getCookie());
        });

    }
    public static function getCookie(){
        $cookie_id=Cookie::get("cart_id");
        if(!$cookie_id){
            $cookie_id=Str::uuid();
            Cookie::queue("cart_id",$cookie_id,30*24*60);
        }
        return $cookie_id;
    }
    public function user(){
        return $this->belongsTo(User::class,"user_id","id")->withDefault([
            'name'=>'anymous'
        ]);
    }
    public function product(){
        return $this->belongsTo(Product::class,"product_id","id")->withDefault();
    }
}
