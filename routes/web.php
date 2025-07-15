<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [AdminController::class, 'index']);
Route::post('/register', [AdminController::class, 'store'])->name('user.store');


