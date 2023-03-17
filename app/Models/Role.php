<?php

namespace App\Models;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    protected $guarded=[];
    use HasFactory;
    public static function createWithAbilities(Request $request){
        DB::beginTransaction();
        try{
          $role=Role::create([
              "name"=>$request->name
          ]);
          foreach($request->post("abilities") as $ability=>$value){
           RoleAbility::create([
             'role_id'=>$role->id,
             'ability'=>$ability,
             'type'=>$value
           ]);
          }
          DB::commit();
          return redirect()->route("admin.role.create")->with("success","successfully created role");
        }catch(Exception $e){
          DB::rollBack();
          return redirect()->back()->withErrors(["error"=>$e->getMessage()]);
        } 
    }
    public function updateWithAbilities(Request $request){
        DB::beginTransaction();
        try{
        $this->update(["name"=>$request->post("name")]);
        foreach($request->post("abilities") as $ability=>$value){
            RoleAbility::updateOrCreate([
                'role_id'=>$this->id,
                'ability'=>$ability,
            ],[
                'type'=>$value
            ]);
        }
        DB::commit();
        return redirect()->route("admin.role.index")->with("success","successfully created role");
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(["error"=>$e->getMessage()]);
        }
    }
    public function abilities(){
        return $this->hasMany(RoleAbility::class,"role_id","id");
    }
}
