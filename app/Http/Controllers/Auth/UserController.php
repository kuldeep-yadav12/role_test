<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class UserController extends Controller
{

    // Show registration form
    public function index()
    {
        return view('auth.register');
    }

    // Store user registration
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'phone' => 'nullable|digits_between:10,15',
            'hobbies' => 'nullable|array',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->gender = $validated['gender'];
        $user->age = $validated['age'];
        $user->phone = $validated['phone'];
        $user->hobbies = implode(',', $validated['hobbies'] ?? []);
        $user->password = Hash::make($validated['password']);
        $user->role = 'system_user';
        $user->save();

        return redirect()->route('login')->with('success', 'User registered successfully!');

    }


public function home()
{
    if (auth()->user()->role === 'admin') {
        $users = User::all();
        $userCount = User::count();
        $postCount = \App\Models\Blog::count();
    } else {
        $users = null;
        $userCount = null;
        $postCount = \App\Models\Blog::where('user_id', auth()->id())->count();
    }

    return view('home', compact('users', 'userCount', 'postCount'));
}


public function listAll()
{
    $users = User::all();
    return view('users', compact('users'));
}


    // Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('auth.edit', compact('user'));
    }

    // Update user info
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:1',
            'phone' => 'nullable|digits_between:10,15',
            'hobbies' => 'nullable|array'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'phone' => $validated['phone'],
            'hobbies' => implode(',', $validated['hobbies'] ?? [])
        ]);

       return redirect()->route('home')->with('success', 'User registered successfully!');

    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if (User::count() === 0) {
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
    }

        return redirect('/')->with('success', 'User deleted successfully!');
    }
}
