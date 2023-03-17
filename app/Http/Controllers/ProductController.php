<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products=Product::withoutGlobalScope('store')->paginate();
        // $products=Product::paginate();
        $this->authorize("view-any",Product::class);
        $products=Product::with(['category','store'])->paginate();
        return view("admin.dashboard.product.index",compact("products"));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::findOrFail($id);
        $this->authorize("update",$product);
         $tags=implode(",",$product->tags()->pluck("name")->toArray());
          return view("admin.dashboard.product.edit",[
            "product"=>$product,
            'tags'=>$tags
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize("update",$product);
        $product->update($request->except("tag"));
        // $tags=explode(",",$request->post("tag"));
        $tags=json_decode($request->post("tag"));
        $saved_tags=Tag::all();
        $tags_id=[];
        foreach($tags as $t_name){
            $slug=Str::slug($t_name->value);
            // $tag=Tag::where("slug",$slug)->first();
            $tag=$saved_tags->where("slug",$slug)->first();
            if(!$tag){
               $tag= Tag::create(
                    ['name'=>$t_name->value,
                    'slug'=>$slug]
                );
            }
            $tags_id[]=$tag->id;
        }
        $product->tags()->sync($tags_id);
        return redirect()->route("admin.product.index")->with("success","sucessfully updated product");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
