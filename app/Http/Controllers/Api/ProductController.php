<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\productResource;

class ProductController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except("index","show");
    }
    public function index(Request $request)
    {
        $products=Product::with("category:id,name")->filter($request->query())->paginate();
        // return $products;
        return productResource::collection($products);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=$request->user();
        $request->validate([
            'name'=>'required||string|min:2|max:15',
            'description'=>'nullable|string|max:225',
            'category_id'=>'required|exists:categories,id',
            'status'=>'in:active,inactive',
            'price'=>'required|numeric|min:0',
            'price_compare'=>'nullable|numeric|gt:price'
        ]);
        if(!$user->tokenCan("products.create")){
           abort(403,"Not Allowed");
        }
        $product=Product::create($request->all());
        return response()->json($product,201,[
            'location'=>route('products.show',$product->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    { 
        $product->load("category:id,name","store:id,name");
       return new productResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product)
    {
       $user=$request->user();
        $request->validate([
            'name'=>'sometimes|required||string|min:2|max:15',
            'description'=>'nullable|string|max:225',
            'category_id'=>'sometimes|required|exists:categories,id',
            'status'=>'in:active,inactive',
            'price'=>'sometimes|required|numeric|min:0',
            'price_compare'=>'nullable|numeric|gt:price'
        ]);
         if(!$user->tokenCan("products.update")){
           return response()->json([
            'message'=>'Not Allowed',
           ],403);
         }
        $product->update($request->all());
        return response()->json($product,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // $product=Product::destroy($id);
        $user=Auth::guard('sanctum')->user();
        if(!$user->tokenCan("products.delete")){
           abort(403,"Not Allowed");
        }
        $productDelete=$product->delete();
        if($productDelete){
            return response()->json([
                'message'=>'products successfully deleted'
            ],200);
        }

        return response()->json([
            'message'=>'products faild deleted'
        ],403);
        
    }
}
