<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission: Delete Role', [ 'only' => ['destroy']]);
    //     $this->middleware('permission: Update Role', [ 'only' => ['edit','update']]);
    // }
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('role-permission.role.index', compact('roles'));

       // return response()->json(['data' => $Role], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'name' => 'required'
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->save();

        $notification = array('message'=>'Role Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

        //return response()->json(['message' => 'Role Added Succesfully!'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $single_role = Role::findOrfail($id);

        return response()->json(['data' => $single_role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
       $role = Role::findOrfail($role->id);
       $roles = Role::all();

       return view('role-permission.role.edit', compact('role', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
         $request->validate([
            'name' => 'required'
        ]);

        $role = Role::find($role->id);
        $role->name = $request->name;
        $role->update();
        
        $notification = array('message'=>'Role Update Successfull', 'alert-type' => 'success');
        return redirect()->route('role.index')->with($notification);

        //return response()->json(['message' => 'Role Update Succesfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete($role->id);

        $notification = array('message'=>'Role Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('role.index')->with($notification);
        
        //return response()->json(['name'=>'Deletede Successfull!'],200);
    }

    public function addPermission(Role $role){

        $role = Role::find($role->id);
        $permissions = Permission::all();
        $rolePermissions = DB::table('role_has_permissions')
                           ->where('role_has_permissions.role_id', $role->id)
                           ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                           ->all();

        return view('role-permission.give-permission', compact('role','permissions','rolePermissions'));
    }
    public function givePermission(Request $request, Role $role){
        
        $request->validate([
            'permissions' => 'required'
        ]);

        $role = Role::find($role->id);
        $role->syncPermissions($request->permissions);
        $notification = array('message' => 'All eprmission assign to role', 'alert-type' => 'success');
        return redirect()->route('role.index')->with($notification);

    }
}
