<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::prefix('blogs')->name('blog.')->group(function () {
    Route::resource('main_blog', BlogController::class);
});

Route::get('register', [AdminController::class, 'index'])->name('register');
Route::post('/register', [AdminController::class, 'store'])->name('user.store');

<<<<<<< HEAD
Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('user.login');
// Route::get('/Dashboard', [LoginRegisterController::class, 'Dashboard']);
// Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('user');
// Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('user.logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [LoginRegisterController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [LoginRegisterController::class, 'index'])->name('admin.users');
    Route::put('/users/{id}', [LoginRegisterController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [LoginRegisterController::class, 'destroy'])->name('admin.users.delete');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/profile', [LoginRegisterController::class, 'show'])->name('user.profile');
    Route::put('/user/profile', [LoginRegisterController::class, 'updateOwn'])->name('user.profile.update');
    Route::delete('/user/profile', [LoginRegisterController::class, 'deleteOwn'])->name('user.profile.delete');
});
=======



Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('login.submit');
>>>>>>> 400ff88473ad97feb15daa08b712a352ae329eeb
