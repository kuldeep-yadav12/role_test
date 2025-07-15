<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('home');
});

Route::get('register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store'])->name('user.store');




Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('user.login');
Route::get('/Dashboard', [LoginRegisterController::class, 'Dashboard']);
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('user');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('user.logout');

