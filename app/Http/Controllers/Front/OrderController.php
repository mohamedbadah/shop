<?php

namespace App\Http\Controllers\front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show(Order $order){
        $delivery=$order->delivery()->select([
            'id',
            'status',
             'order_id',
            DB::raw("ST_X(current_location) as lat"),
            DB::raw("ST_Y(current_location) as lng")
        ])->first();
    return view("front.delivery.show",["delivery"=>$delivery,'order'=>$order]);
    }
}
