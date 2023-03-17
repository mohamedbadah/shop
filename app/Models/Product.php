<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scopes\StoreScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=["created_at","updated_at","option","image"];
    public static function booted(){
        // static::addGlobalScope("store",function(Builder $query){
        //     $user=Auth::user();
        //     if($user->store_id){
        //      $query->where("store_id",$user->store_id);
        //     }
        // });
        // static::addGlobalScope("store",new StoreScope());
        static::creating(function(Product $product){
            $product->slug=Str::slug($product->name);
        });
        static::updating(function(Product $product){
            $product->slug=Str::slug($product->name);
        });
    }
    public function category(){
        return $this->belongsTo(Category::class,"category_id","id");
    }
    public function store(){
        return $this->belongsTo(Store::class,"store_id","id");
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,"product_tag",
        "product_id"
        ,"tag_id"
        ,"id",
        "id");
    }
    public function scopeActive(Builder $builder){
        $builder->where("status","active");
    }
    protected $appends=["image_Url"];
    public function getImageUrlAttribute(){
        if(!$this->image){
            return "https://ingening.com/wp-content/themes/maximum/images/no_product.png";
        }
        if(Str::startsWith($this->image,['http://',"https://"])){
            return $this->image;
        }
        return asset("storage/$this->image");
    }
    public function getPresentProductAttribute(){
        if(!$this->price_compare){
            return 0;
        }
        return round(100-($this->price/$this->price_compare)*100);
    }
    public function scopeFilter(Builder $builder,$filters){
        $options=array_merge([
            'store_id'=>null,
            'category_id'=>null,
            'status'=>'active',
            'tag_id'=>null,
        ],$filters);

    $builder->when($options['store_id'],function($builder,$value){
        $builder->where("store_id",$value);
    });

    $builder->when($options['category_id'],function($builder,$value){
       $builder->where("category_id",$value);
    });
    $builder->when($options['tag_id'],function($builder,$value){
        // $builder->whereHas("tags",function($query) use ($value){
        //     $query->whereIn("id",$value);
        // });
        // $builder->whereRaw("id IN (select product_id from product_tag where tag_id=?)",[$value]);
    //    $builder->whereRaw("EXISTS(select 1 from product_tag where tag_id=? And
    //    product_id=products.id)",[$value]);
       $builder->whereExists(function($query) use ($value){
           $query->select(1)
           ->from("products_tag")
           ->whereRaw("product_id=products.id")
           ->where("tag_id",$value);
       });
    });
    $builder->when($options['status'],function($builder,$value){
       $builder->where("status",$value);
    });

    }
}
