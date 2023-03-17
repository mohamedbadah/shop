<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;
    public $timestamps=false;
    public $incrementing=true;
    protected $table="order_items";
    public function product(){
        return $this->belongsTo(Product::class,"product_id","id"
        )->withDefault([
            'name'=>$this->product_name
        ]);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
