<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportedProductsController extends Controller
{
    public function create(){
        return view("admin.dashboard.product.import");
    }
    public function store(Request $request){
        $request->validate([
            'count'=>'numeric'
        ]);
        $job=new ImportProducts($request->post("count"));
        // $job->onQueue("import")->delay(now()->addSeconds(5));
        // $this->dispatch($job);
            dispatch($job)->onQueue("import")->delay(now()->addSeconds(5));
            // ImportProducts::dispatch($podcast)
            // ->delay(now()->addSeconds(10));
        return redirect()->route("admin.product.index")->with("success","Import is runing ...");
    }
}
