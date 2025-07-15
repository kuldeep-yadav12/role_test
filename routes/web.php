<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('home');
});

Route::get('register', [AdminController::class, 'index'])->name('register');
Route::post('/register', [AdminController::class, 'store'])->name('user.store');




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