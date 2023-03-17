<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index(){
        // return response()->view('admin.dashboard.index');
        // return View('admin.dashboard.index');
        // return Response::View('admin.dashboard.index',[
        //     'user'=>"mohamed badah"
        // ]);
        return View::make('admin.dashboard.index',[
            'user'=>"mohamed badah"
        ]);
    }
}
