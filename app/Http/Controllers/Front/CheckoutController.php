<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use App\Repository\Cart\CartRepository;

class CheckoutController extends Controller
{
    public function index(CartRepository $cart){
      if($cart->getItem()->count()==0){
             throw new InvalidOrderException("cart is empty");
      }
        return view("front.checkout",[
            'cart'=>$cart,
            'countries'=>Countries::getNames(),
        ]);
    }
    public function checkout(Request $request,CartRepository $cart){
        DB::beginTransaction();
        try{
        $items=$cart->getItem()->groupBy('product.store_id');
        foreach($items as $store_id=>$item){
            $order = Order::create([
                'store_id' => $store_id,
                'user_id' => Auth::id(),
                'payment_method' => 'cod',
            ]);
              foreach($cart->getItem() as $item){
                OrderItem::create([
                  'order_id'=>$order->id,
                  'product_id'=>$item->product_id,
                  'product_name'=>$item->product->name,
                  'price'=>$item->product->price,
                  'quantity'=> $item->quantity,
                ]);
              }
              foreach($request->addr as $type=>$address){
                  $address['type']=$type;
                  $order->address()->create($address);
              }
        }
          DB::commit();
          // event('order.create',$order,Auth::user());  
          event(new OrderCreated($order));
        }catch(Throwable $e){
           DB::rollBack();
           throw $e;
        }  
        // return redirect()->route('home')->with("success","successfully created order");
        return redirect()->route("order.payment.create",$order->id);
    }
}
