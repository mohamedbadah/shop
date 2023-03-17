<?php

namespace App\Http\Controllers\dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Locales;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
    public function edit(){
        $user=Auth::user();
        return view("admin.dashboard.profile.edit",[
            "user"=>$user,
            'countries'=>Countries::getNames("ar"),
            'Locales'=>Locales::getNames(),
        ]);
    }
    public function update(Request $request){
        $user=$request->user();
        $request->validate([
            "first_name"=>["required","string","min:3","max:10"],
            "last_name"=>["required","string","min:3","max:10"],
            "birthday"=>["required","date","before:today"],
            "gender"=>["in:male,female"],
            'country'=>['required','string','size:2'],
            'locale'=>['required','string','size:2'],
        ]);
        $user->profile->fill($request->all())->save();
        // $profile=$user->profile;
        // if($profile->first_name){
        //     $profile->update($request->all());
        // }else{
        //     $request->merge([
        //         "user_id"=>$user->id
        //     ]);
        //   $profile->create($request->all());
        // }
        return redirect()->route('admin.profile')->with("success","successfully update profile");
    }
}
