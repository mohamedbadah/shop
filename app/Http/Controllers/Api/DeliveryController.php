<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function show($id){
       $delivery=Delivery::select([
        'status',
        'order_id',
        DB::raw("ST_X(current_location) as lat"),
        DB::raw("ST_Y(current_location) as lng")
       ])->where("id",$id)->first();
       return $delivery;
    }
    public function update(Request $request,Delivery $delivery){
        $request->validate([
            'lat'=>'required|numeric',
            'lng'=>'required|numeric'
        ]);
        $delivery->update([
            "current_location"=>DB::raw("POINT({$request->lat},{$request->lng})")
        ]);
        return $delivery;
    }
}
