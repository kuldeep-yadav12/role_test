<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BlogController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // if (User::count() === 0) {
    //     return redirect('/register')->with('status', 'No users exist. Please register first.');
    // }

    if (!Auth::check()) {
        return view('auth.login'); 
    }

    return app(UserController::class)->home(); 
})->name('home');

Route::get('/register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store'])->name('user.store');

// Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/all-users', [UserController::class, 'listAll'])->name('user.list');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::prefix('blogs')->name('blog.')->group(function () {
    Route::resource('main_blog', BlogController::class);
});



Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
