<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RoleAbility;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class,'role');
        
    }
    public function index()
    {
        $this->authorize("view-any",Role::class);
        $roles=Role::paginate();
        return view("admin.dashboard.role.index",compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create",Role::class);
        $role=new Role();
        $role_ability=new RoleAbility();
        return view("admin.dashboard.role.create",compact("role","role_ability"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'name'=>'required|string',
        'abilities'=>'required|array'
      ]);
      Role::createWithAbilities($request);
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
    public function edit(Role $role)
    {
        $this->authorize("update",$role);
        $role_ability=$role->abilities()->pluck("type","ability");
        // dd($role_ability);
        return view("admin.dashboard.role.edit",compact("role","role_ability"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        $this->authorize("update",$role);
        $request->validate([
            'name'=>'required|string',
            'abilities'=>'required|array'
          ]);
          $role->updateWithAbilities($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize("destroy",$role);
        $role->delete();
        return redirect()->route("admin.role.index")->with("success","successfully deleted role");
    }
}
