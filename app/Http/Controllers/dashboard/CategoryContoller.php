<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CategoryContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows("category.view")){
          abort(403);
        }
        // $categories=Category::all();
        $request=request();
        $query=Category::query(); //row
        // if($name=$request->query('name')){
        // $query->where('name','like',"%{$name}%");
        // }
        // if($status=$request->query("status")){
        //     $query->where("status","=",$status);
        // }
        // $categories=$query->paginate(1);
        // $categories=Category::active()->paginate(2);
        // $categories=Category::status('inactive')->paginate(2);
        // $categories=Category::filter($request->query())->paginate(4);

        //select a.* b.name as parent_name from 
        // categories as a
        // LEFT JOIN categories as b on b.id =a.parent_id
    //    $categories=Category::leftJoin("categories as parents","parents.id","=","categories.parent_id")
    //    ->select(['categories.*',
    //    'parents.name as parent_name'
    //    ])
    //    ->filter($request->query())
    //    ->orderBy('categories.name')
    //    ->paginate();
    // $categories=Category::leftJoin("categories as parents","parents.id","=","categories.parent_id")
    // ->select(['categories.*',
    // 'parents.name as parent_name'])->filter($request->query())
    // ->orderBy("categories.name")->paginate(2);
    $categories=Category::with("parent")->select("categories.*")
    // ->selectRaw("(select COUNT(*) from products where category_id=categories.id) as product_count")
    ->withCount([
        'products'=>function($query){
            $query->where("status","=","active");
        }
    ])
    ->filter($request->query())
    ->orderBy("categories.name")->paginate(5);

        //    $categories=Category::filter($request->query())->paginate(3);
        return view("admin.dashboard.category.index",compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize("category.create");
        $category=new Category();
        $parent=Category::all();
        return view("admin.dashboard.category.create",compact("parent",'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $request->validate(Category::rules());
        try{
            $request->merge(['slug'=>Str::slug($request->post("name"))]);
            // $category=new Category($request->all());
            // // $category->slug=Str::slug($request->name);
            // $category->save();
            $data=$request->except('image');
            $data['image']=$this->uploadImage($request);
            Category::create($data);
            return redirect()->route('admin.category.index')->with("success","successfully created category");
        }catch(Exception $e){
            return redirect()->route('admin.category.index')->withErrors(['error'=>$e]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view("admin.dashboard.category.show",[
            "category"=>$category
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::findOrFail($id);
        // $parent=Category::all();
        // select * from categories where id!=$id and (parent_id is null or parent_id!=$id)
       $parent=Category::where("id","<>",$id)->where(function($query) use ($id){
          $query->whereNull("parent_id")->orWhere("parent_id","<>",$id);
       })->get();
        return view("admin.dashboard.category.edit",compact("parent","category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
    //   $request->validate(Category::rules($id));
        try{
            $category=Category::findOrFail($id);
            // $category->fill($request->all())->save();
           $data=$request->except("image");
           $old_image=$category->image;
            $new_image=$this->uploadImage($request);
            if($new_image){
                $data['image']=$new_image;
            }
            $category->update($data);
            if($old_image && $new_image){
               Storage::disk("public")->delete($old_image);
            }
            return redirect()->route('admin.category.index')->with("success","successfully update category");

        }catch(Exception $e){
            return redirect()->route('admin.category.index')->withErrors(["error"=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $is_deleted=$category->delete();
        if($is_deleted){
            Storage::disk("public")->delete($category->image);
        }
        // Category::destroy($id);
        return redirect()->back()->with("success","successfully delete item category");
    }
    protected function uploadImage(Request $request){
        if(!$request->hasFile('image')){
            return ;
        } 
            $file=$request->file("image");
            $new_image="category_".time().".".$file->getClientOriginalExtension();
            $path=$file->storeAs("uploads",$new_image,[
                'disk'=>'public'
            ]);
            // $path=$file->store("uploads",[
            //   'disk'=>'public'
            // ]);
            return $path;
    }

    public function trash(){
        $categories=Category::onlyTrashed()->paginate(2);
        return view("admin.dashboard.category.trash",compact("categories"));
    }
    public function restore($id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.category.index')->with("success","successfully restore item");
        
    }
    public function forceDelete($id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $is_deleted= $category->forceDelete();
        if($is_deleted){
            Storage::disk("public")->delete($category->image);
        }
        return redirect()->route('admin.category.index')->with("success","successfully Delete item");

    }
}
