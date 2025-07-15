<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('home');
});

Route::get('register', [AdminController::class, 'index'])->name('register');
Route::post('/register', [AdminController::class, 'store'])->name('user.store');




Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('logout');



Route::get('/admin/dashboard', [LoginRegisterController::class, 'dashboard'])->name('admin.dashboard');


Route::get('/admin/users', [LoginRegisterController::class, 'index'])->name('admin.users.index');
Route::post('/admin/users/{id}/update', [LoginRegisterController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}/delete', [LoginRegisterController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/user/profile', [LoginRegisterController::class, 'show'])->name('user.profile');
Route::post('/user/profile/update', [LoginRegisterController::class, 'updateOwn'])->name('user.profile.update');
Route::delete('/user/profile/delete', [LoginRegisterController::class, 'deleteOwn'])->name('user.profile.delete');
