<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Cart\CartRepository;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartRepository $cart)
    {
        return view("front.cart",[
            'cart'=>$cart
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,CartRepository $cart)
    {
        $request->validate([
            'product_id'=>'required|int|exists:products,id',
            'quantity'=>'nullable|int|min:1'
        ]);
        $product=Product::findOrFail($request->post("product_id"));
        $cart->add($product,$request->post("quantity"));
        return redirect()->route("cart.index")->with("success","successfully created new cart");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,CartRepository $cart,$id)
    {
        $request->validate([
            'quantity'=>'required|int|min:1'
        ]);
        $cart->update($id,$request->post("quantity"));
        return redirect()->route("cart.index")->with("success","successfully created new cart");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartRepository $cart,$id)
    {
        $cart->delete($id);
    }
}
