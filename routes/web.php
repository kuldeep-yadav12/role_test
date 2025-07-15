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
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('login.submit');
