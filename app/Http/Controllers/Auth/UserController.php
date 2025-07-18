<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Show registration form
    public function index()
    {
        return view('auth.register');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    // Store user registration
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'gender'   => 'required|in:Male,Female',
            'age'      => 'required|integer|min:1',
            'phone'    => 'nullable|digits_between:10,15|unique:users',
            'hobbies'  => 'nullable|array',
            'password' => 'required|min:6|confirmed',
        ]);

        $user           = new User();
        $user->name     = $validated['name'];
        $user->email    = $validated['email'];
        $user->gender   = $validated['gender'];
        $user->age      = $validated['age'];
        $user->phone    = $validated['phone'];
        $user->hobbies  = implode(',', $validated['hobbies'] ?? []);
        $user->password = Hash::make($validated['password']);
        $user->role     = 'system_user';
        $user->save();

        return redirect()->route('login')->with('success', 'User registered successfully!');

    }

    public function home()
    {
        if (auth()->user()->role === 'admin') {
            $users     = User::all();
            $userCount = User::count();
            $trashedUsers = User::onlyTrashed()->get();
            $postCount = \App\Models\Blog::count();
        } else {
            $users     = null;
            $userCount = null;
            $trashedUsers  = collect();
            $postCount = \App\Models\Blog::where('user_id', auth()->id())->count();
        }

        return view('home', compact('users', 'userCount', 'postCount','trashedUsers'));
    }

    public function listAll(Request $request)
{
    $query = User::query();

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('phone')) {
        $query->where('phone', 'like', '%' . $request->phone . '%');
    }

    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }

    if ($request->filled('age')) {
        $query->where('age', $request->age);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $users = $query->get();
    $trashedUsers = User::onlyTrashed()->get();

     if ($request->ajax()) {
    $html = view('partials.user-table', ['users' => $users, 'showActions' => true])->render();
    return response()->json(['html' => $html]);
}


    $userCount = User::count();
    $postCount = \App\Models\Blog::count();
    return view('home', compact('users','userCount', 'postCount', 'trashedUsers'));
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
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $id,
            'gender'  => 'required|in:Male,Female',
            'age'     => 'required|integer|min:1',
            'phone'   => 'required|digits_between:10,15|unique:users,phone,' . $id,
            'hobbies' => 'nullable|array',
        ]);

        $user->update([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'gender'  => $validated['gender'],
            'age'     => $validated['age'],
            'phone'   => $validated['phone'],
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

    public function profile_update(Request $request, $id = '')
    {
        $user = User::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_image', 'public');

            if ($user->image && \Storage::disk('public')->exists($user->image)) {
                \Storage::disk('public')->delete($user->image);
            }

            $user->image = $imagePath;
            $user->save();
        }

        return redirect()->route('user.profile')->with('success', 'Profile image updated successfully!');
    }

  

    public function restore($id)
{
    $user = User::onlyTrashed()->findOrFail($id);
    $user->restore();

    return redirect()->back()->with('success', 'User restored successfully!');
}

public function forceDelete($id)
{
    $user = User::onlyTrashed()->findOrFail($id);
    $user->forceDelete();

    return redirect()->back()->with('success', 'User permanently deleted!');
}

public function bulkSoftDelete(Request $request)
{
    $request->validate([
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id',
    ]);

    // Exclude current user (admin himself)
    $userIds = array_diff($request->user_ids, [auth()->id()]);

    User::whereIn('id', $userIds)->delete();

    return response()->json(['message' => 'Selected users soft deleted successfully.']);
}


    

}
