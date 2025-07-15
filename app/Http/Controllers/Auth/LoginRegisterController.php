<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends Controller
{
   

    public function showLogin()
    { 
        return view('auth.login');
     }


   public function login(Request $request)
   {
       $users = $request->validate([
           'username'  => 'required',
           'useremail'    => 'required',
           'userpass' => 'required',
       ]);


       if(Auth::attempt($users)){
        return redirect()->route('/')
         ->with('status','User is Logged In Successfully');
       }else{
        return redirect()->route('register')
         ->with('status','Please fill the Register Form First');
       }

}

public function Dashboard(){
if(Auth::check()){
    return view();
}else{
 return redirect()->route('login')
         ->with('status','Please Login First');
}

}

public function logout(){
    Auth::logout();
    return view('auth.login');
}
}
