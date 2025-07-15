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
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return redirect()->route('register')->with('status', 'You are not registered. Please register first.');
    }

    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        return $user->role === 'admin'
            ? redirect()->route('/')->with('status', 'Admin logged in')
            : redirect()->route('')->with('status', 'User logged in');
    }

    return redirect()->route('login')->with('status', 'Invalid data.');
}

}
