<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PostController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.delete');

    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('post.save');
    Route::get('/products/{id}', [PostController::class, 'show'])->name('post.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{postId}', [CartController::class, 'store'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');

    Route::middleware(['role:admin,superadmin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index']);
        Route::get('/admin/users', [AdminController::class, 'manageUsers']);
    });


});
