<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! Auth::check()) {
        return view('auth.login');
    }

    return app(UserController::class)->home();
})->name('home');

Route::get('/register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store'])->name('user.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/all-users', [UserController::class, 'listAll'])->name('user.list');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::resource('blogs/main_blog', BlogController::class)->names('blog.main_blog');
    Route::prefix('blogs')->name('blog.')->group(function () {
        Route::resource('main_blog', BlogController::class);
    });
});

Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
Route::put('/profile/update/{id}', [UserController::class, 'profile_update'])->name('profile.update');

Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
