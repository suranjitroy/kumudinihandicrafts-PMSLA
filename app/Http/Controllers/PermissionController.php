<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
     public function __construct(){

        //$this->middleware(['role:super-admin|admin','permission:delete permissions']);

        //$this->middleware(['role:admin','permission:delete permissions']);

        $this->middleware('permission:delete permissions', ['only' => ['destroy']]); 
        $this->middleware('permission:update permission', ['only' => ['edit', 'update']]); 
        $this->middleware('permission:create permission', ['only' => ['create','store']]); 
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('role-permission.permission.index', compact('permissions'));

       // return response()->json(['data' => $permission], 200);
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

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        $notification = array('message'=>'Permission Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);

        //return response()->json(['message' => 'Permission Added Succesfully!'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $single_permission = Permission::findOrfail($id);

        return response()->json(['data' => $single_permission]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
       $permission = Permission::findOrfail($permission->id);
       $permissions = Permission::all();

       return view('role-permission.permission.edit', compact('permission', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
         $request->validate([
            'name' => 'required'
        ]);

        $permission = Permission::find($permission->id);
        $permission->name = $request->name;
        $permission->update();
        
        $notification = array('message'=>'Permission Update Successfull', 'alert-type' => 'success');
        return redirect()->route('permission.index')->with($notification);

        //return response()->json(['message' => 'Permission Update Succesfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete($permission->id);

        $notification = array('message'=>'Permission Delete Successfull', 'alert-type' => 'success');

        return redirect()->route('permission.index')->with($notification);
        
        //return response()->json(['name'=>'Deletede Successfull!'],200);
    }
    // public function delete(Permission $permission)
    // {
    //     $permission->delete($permission->id);

    //     $notification = array('message'=>'Permission Delete Successfull', 'alert-type' => 'success');

    //     return redirect()->route('permission.index')->with($notification);
        
    //     //return response()->json(['name'=>'Deletede Successfull!'],200);
    // }
}
