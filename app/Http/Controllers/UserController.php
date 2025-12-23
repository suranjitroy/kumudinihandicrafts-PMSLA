<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('role-permission.users.index',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'user_name' => 'required|string',
            'password' => 'required|string|min:5|max:20',
            'roles' => 'required'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->syncRoles($request->roles);
        $notification = array('message'=>'User Added Successfull', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('role-permission.users.edit', compact('user','roles','userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
                    'name' => 'required|string',
                    'user_name' => 'required|string',
                    'password' => 'nullable|string|min:5|max:20',
                    'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'user_name' => $request->user_name,
            'email' => $request->email, 
        ];
        if(!empty($request->password)){
        $data += [
            'password' =>  Hash::make($request->password),
        ];
    }
        $user->update($data);
        $user->syncRoles($request->roles);
        $notification = array('message'=>'User Updated Successfull', 'alert-type' => 'success');
        return redirect()->route('users.index')->with($notification);
        
        // $user = new User;
        // $user->name = $request->name;
        // $user->user_name = $request->user_name;
        // $user->email = $request->email;
        // if(!empty($request->password)){
        //  $user->password = Hash::make($request->password);
        // }
        // $user->update();
        // $user->syncRoles($request->roles);
        // $notification = array('message'=>'User Updated Successfull', 'alert-type' => 'success');
        // return redirect()->route('users.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $deleteID = User::findOrFail($user->id);
        $user->delete($deleteID);

        $notification = array('message'=>'User Deleted Successfull', 'alert-type' => 'success');
        return redirect()->route('users.index')->with($notification);
    }
}
