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

        if (Auth::attempt($credentials)) {
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
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $authUser = Auth::user();
        $user = User::findOrFail($id);

        if ($authUser->role !== 'admin' && $authUser->id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $authUser = Auth::user();
        $user = User::findOrFail($id);

        if ($authUser->role !== 'admin' && $authUser->id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $user->delete();

        if ($authUser->id === $user->id) {
            Auth::logout();
            return redirect('/')->with('status', 'Your account has been deleted.');
        }

        return back()->with('success', 'User deleted successfully.');
    }

    public function show()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function updateOwn(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'Your profile has been updated.');
    }

    public function deleteOwn()
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();

        return redirect('/')->with('status', 'Your account has been deleted.');
    }

    public function dashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        return view('admin.dashboard');
    }
}
