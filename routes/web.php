<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;



Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register/send-code', [RegisterController::class, 'sendVerificationCode'])->name('register.sendCode');
    Route::post('/register/verify', [RegisterController::class, 'verifyAndRegister'])->name('register.verify');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password/send-code', [ForgotPasswordController::class, 'sendResetCode'])->name('password.sendCode');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

});


Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.delete');

    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('post.save');
    Route::get('/products/{id}', [PostController::class, 'show'])->name('post.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{postId}', [CartController::class, 'store'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');

        Route::middleware(['auth', 'can:access-admin-panel'])->prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::patch('/posts/{post}/toggle-block', [AdminController::class, 'toggleBlockPost'])->name('admin.posts.toggleBlock');
            Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
            Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
            Route::patch('/users/{user}/toggle-active', [AdminController::class, 'toggleActiveUser'])->name('admin.users.toggleActive');
        });
});
