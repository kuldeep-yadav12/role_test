<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CommentController;

Route::get('/register', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store'])->name('user.store');

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [UserController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

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
    Route::post('/like-toggle', [BlogController::class, 'toggleLikeDislike'])->name('like.toggle');


    Route::get('/all-users', [UserController::class, 'listAll'])->name('user.list');

    Route::get('/main-blogs', [BlogController::class, 'blogFilter'])->name('blog.main_blog.index');

    Route::get('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    Route::delete('/user/force-delete/{id}', [UserController::class, 'forceDelete'])->name('user.forceDelete');

    Route::post('/users/bulk-soft-delete', [UserController::class, 'bulkSoftDelete'])->name('users.bulkSoftDelete');

    Route::post('/users/bulk-restore', [UserController::class, 'bulkRestore'])->name('users.bulkRestore');
    Route::delete('/blog-images/{id}', [BlogController::class, 'deleteImage'])->name('blog_media.delete');
    Route::post('/blog-images/reorder', [BlogController::class, 'reorderImages'])->name('blog_media.reorder');
    Route::post('/blog/{id}/restore', [BlogController::class, 'restore'])->name('blog.restore');
    Route::delete('/blog/{id}/force-delete', [BlogController::class, 'forceDelete'])->name('blog.forceDelete');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/comment/{id}', [CommentController::class, 'show'])->name('comments.show');
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');

});
