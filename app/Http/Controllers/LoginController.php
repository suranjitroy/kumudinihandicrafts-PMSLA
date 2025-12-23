<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('login.login');
    }
    public function loginPost(Request $request){

        $credential = $request->validate([
            'user_name' => 'required|exists:users,user_name', 
            'password' => 'required|min:5'
        ]);

        if(Auth::attempt($credential)){
        $request->session()->regenerate();

        $notification = array('message'=>'Login Successfull', 'alert-type' => 'success');
        return redirect('/dashboard')->with($notification);

        }else{
            return redirect('/');
        }
        
        
    }

    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        $notification = array('message'=>'Logout Successfull', 'alert-type' => 'success');

        return redirect('/')->with($notification);
    }
}
