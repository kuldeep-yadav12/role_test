<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/')->with('status', 'You are already logged in.');
        }
        return view('auth.login');
    }


public function login(Request $request)
{

    $users = $request->validate([
        'login'    => 'required|string',
        'password' => 'required|string',
    ]);

  
    $fieldType = filter_var($users['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

    $user = User::where($fieldType, $users['login'])->first();

    if (!$user) {
        return redirect('/register')->with('status', 'You are not registered. Please register first.');
    }

    if (Hash::check($users['password'], $user->password)) {
        Auth::login($user);
        return redirect('/')->with('status', 'Logged in successfully');
    }

    return redirect()->route('login')->with('status', 'Invalid credentials. Try again.');
}


    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Logged out successfully.');
    }

}
