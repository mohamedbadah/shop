<?php
namespace App\Concerns;

use App\Models\Role;

trait HasRole{
    public function roles(){
        return $this->morphToMany(Role::class,"authorizable","role_user");
    }
    public function hasAbilities($ability){
        $deny =$this->roles()->whereHas("abilities",function($query) use ($ability){
          $query->where("ability",$ability)->where("type","deny");
        })->exists();
        if($deny){
            return false;
        }

        return $this->roles()->whereHas("abilities",function($query) use ($ability){
            $query->where("ability",$ability)->where("type","allows");
          })->exists();

    } 
}
?>