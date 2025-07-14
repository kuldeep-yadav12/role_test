<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('user.login');
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('user');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('user.logout');

