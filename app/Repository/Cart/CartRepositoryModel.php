<?php
namespace App\Repository\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Collection;

class CartRepositoryModel implements CartRepository{
    protected $items;
    public function __construct()
    {
        $this->items=collect([]);
    }
    public function getItem()
    {
        // $user=Auth::id();
        // $item=Cart::with('product')->get();
        // return $item;
        if(!$this->items->count()){
          $this->items=Cart::with("product")->get();
        }
        return $this->items;
        
    }
    public function add(Product $product,$quantity=1)
    {
        $item=Cart::where("product_id",$product->id)
        ->first();
          if(!$item){
           $cart=Cart::create([
            'user_id'=>Auth::id(),
            'product_id'=>$product->id,
            'quantity'=>$quantity
           ]);
           return $this->getItem()->push($cart);
        //    return $cart;
          }
        return $item->increment('quantity',$quantity);
    }

    public function update($id, $quantity)
    {
        $cart=Cart::where("id",$id)
        ->update([
            'quantity'=>$quantity
        ]);
        
    }
    public function delete($id)
    {
        // $cart=Cart::where("product_id",$id)->where("cookie_user",$this->getCookie())->first();
        $cart=Cart::where("id",$id)->first();
        $cart->delete();
        
    }

    public function empty()
    {
        // Cart::where("cookie_user",$this->getCookie())->destory();
        Cart::query()->delete();
    }
    public function total():float
    {
        // $cart=Cart::join("products","products.id","=","carts.product_id")
        // ->selectRaw('sum(products.price*quantity) as total')
        // ->value('total');
        // return (float)$cart;
        return $total=$this->getItem()->sum(function($query){
         return $query->quantity*$query->product->price;
        });
    }
   
}
?>