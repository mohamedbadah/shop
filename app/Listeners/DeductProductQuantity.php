<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facade\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repository\Cart\CartRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    // public function handle(Order $order,$user=null)
    // {
    //     foreach($order->products as $product){
    //         $product->decrement("quantity",$product->order_item->quantity);
    //     }
    // //    foreach(Cart::getItem() as $item){
    // //       Product::where("id",$item->product_id)->update([
    // //         'quantity'=>DB::raw("quantity - {$item->quantity}")
    // //       ]);
    // //    }
        
    // }
    public function handle(OrderCreated $event)
    {
        $order=$event->order;
        foreach($order->products as $product){
            $product->decrement("quantity",$product->order_item->quantity);
        }
    //    foreach(Cart::getItem() as $item){
    //       Product::where("id",$item->product_id)->update([
    //         'quantity'=>DB::raw("quantity - {$item->quantity}")
    //       ]);
    //    }
        
    }
}
