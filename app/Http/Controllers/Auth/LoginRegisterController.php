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
    { return view('auth.login');
     }


   public function login(Request $request)
   {
       $users = $request->validate([
           'username'  => 'required',
           'useremail'    => 'required',
           'userpass' => 'required',
       ]);

 return redirect()->route('register')
         ->with('status','User is Logged In Successfully');

}

}
