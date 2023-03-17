<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name','description','status','parent_id','slug','image'];
    public static function rules($id=0){
        return [
            // 'name'=>'required|string|min:3|max:25|unique:categories,name,'.$id,
            'name'=>[
                'required',
                'string',
                'min:3',
                'max:225',
                Rule::unique('categories','name')->ignore($id),
                // function($attribute,$value,$fails){
                //     if(strtolower($value)=="laravel"){
                //         $fails("the name is forbidden!");
                //     }
                // }
                // new Filter(["laravel","php","css"]),
                'filter:php,laravel,css'
            ],
            'image'=>'image|mimes:png,jpg|max:1240000|dimensions:min-height=100,max-height=400',
            'parent_id'=>['nullable','int','exists:categories,id'],
            'status'=>['in:active,inactive']
        ];
    }

    public function scopeActive(Builder $builder){
      $builder->where('status','=','active');
    }
    public function scopeStatus(Builder $builder,$status){
        $builder->where("status",$status);
    }
    // public function scopeFilter(Builder $builder,$filter){
    //     if($filter['name'] ?? false){
    //     $builder->where('name','like',"%{$filter['name']}%");
    //     }
    //     if($filter['status'] ?? false){
    //         $builder->where("status","=",$filter['status']);
    //     }
      
    // }
    public function scopeFilter(Builder $builder,$filter){
        // if($filter['name'] ?? false){
        //    $builder->where("name","like","%{$filter['name']}%");
        // }
        $builder->when($filter['name'] ?? false,function($builder,$value){
            $builder->where("categories.name","like","%{$value}%");
        });
        if($filter['status'] ?? false){
            $builder->where("categories.status","=",$filter["status"]);
        }
   }

   public function products(){
    return $this->hasMany(Product::class,"category_id","id");
   }
   public function children(){
    return $this->hasMany(Category::class,"parent_id","id");
   }
   public function parent(){
    return $this->belongsTo(Category::class,"parent_id","id")->withDefault([
        'name'=>"main category"
    ]);
   }
}
