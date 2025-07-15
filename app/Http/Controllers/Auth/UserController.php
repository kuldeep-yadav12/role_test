<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

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
        $user->save();

        return redirect()->back()->with('success', 'User registered successfully!');
    }
}
