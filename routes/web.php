<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store'])->name('user.store');

Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [LoginRegisterController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'home'])->name('home');

    Route::get('/all-users', [UserController::class, 'listAll'])->name('user.list');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::resource('blogs/main_blog', BlogController::class)->names('blog.main_blog');
    Route::prefix('blogs')->name('blog.')->group(function () {
        Route::resource('main_blog', BlogController::class);
    });

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/update/{id}', [UserController::class, 'profile_update'])->name('profile.update');

    // Route::post('/blogs/{blog}/like', [LikeController::class, 'LikeDislike'])->name('blogs.like');
    Route::post('/like-toggle', [LikeController::class, 'toggleLikeDislike'])->name('like.toggle');

    
    Route::get('/all-users', [UserController::class, 'listAll'])->name('user.list');

    Route::get('/main-blogs', [BlogController::class, 'blogFilter'])->name('blog.main_blog.index');
    
    Route::get('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    Route::delete('/user/force-delete/{id}', [UserController::class, 'forceDelete'])->name('user.forceDelete');

    

});

Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
