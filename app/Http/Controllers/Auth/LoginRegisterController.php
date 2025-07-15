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
            'name'=> 'required',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($users)) {
            $user = Auth::user();

            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')->with('status', 'Admin logged in')
                : redirect()->route('user.profile')->with('status', 'User logged in');
        }

        return redirect()->route('register')->with('status', 'Invalid credentials or not registered.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Logged out successfully.');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() != $user->id) {
            abort(403, 'Unauthorized.');
        }

        $user->update($request->only(['name', 'email', 'password']));
        return back()->with('success', 'User updated.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() != $user->id) {
            abort(403, 'Unauthorized.');
        }

        $user->delete();

        if (Auth::id() == $id) {
            Auth::logout();
            return redirect('/')->with('status', 'Your account has been deleted.');
        }

        return back()->with('success', 'User deleted.');
    }


    public function show()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function updateOwn(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'password']));
        return back()->with('success', 'Profile updated.');
    }

    // User: Delete own profile
    public function deleteOwn()
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();

        return redirect('/')->with('status', 'Your account has been deleted.');
    }

    // Admin: dashboard view (can be empty or just a welcome)
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}

