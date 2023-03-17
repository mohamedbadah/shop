<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\OrderAdrees;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function store(){
        return $this->belongsTo(Store::class,"store_id","id");
    }
    public function user(){
        return $this->belongsTo(User::class,"user_id","id")->withDefault([
            "name"=>"anymouses"
        ]
        );
    }
    public function products(){
        return $this->belongsToMany(Product::class,OrderItem::class,"order_id"
        ,"product_id","id","id")->using(OrderItem::class)->as("order_item")
        ->withPivot(['product_name','price','quantity','option']);
    }
    public function address(){
        return $this->hasOne(OrderAdrees::class);
    }
    public function billingAddress(){
        return $this->hasOne(OrderAdrees::class)->where("type","billing");
    } 
    public function shippingAdress(){
        return $this->hasOne(OrderAdrees::class)->where("type","shipping");
    }
    public static function booted(){
      static::creating(function(Order $order){
        $order->number=Order::getNextYear();
      });
    }
    public static function getNextYear(){
        $year=Carbon::now()->year;
        $number=Order::whereYear("created_at",$year)->max("number");
        if($number){
            return $number+1;
        }
        return $year.'0001';
    }

    public function items(){
        return $this->hasMany(OrderItem::class,"order_id","id");
    }
    public function delivery(){
        return $this->hasOne(Delivery::class,"order_id","id");
    }
}
