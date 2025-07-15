<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::prefix('blogs')->name('blog.')->group(function () {
    Route::resource('main_blog', BlogController::class);
});


// Route::get('/', function () {
//     if (!Auth::check()) {
//         return redirect()->route('login')->with('status', 'Please login first.');
//     }
//     $user = Auth::user();
//     return $user->role === 'admin'
//         ? view('home', compact('user'))
//         : view('user.profile', compact('user'));
// })->name('home');


Route::get('register', [AdminController::class, 'index'])->name('register');
Route::post('/register', [AdminController::class, 'store'])->name('user.store');


Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('login.submit');

