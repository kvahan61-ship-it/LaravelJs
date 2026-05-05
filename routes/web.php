<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', [LoginController::class, 'index'])
    ->middleware('guest')
    ->name('login');

Route::get('/register', [RegisterController::class, 'index'])
    ->middleware('guest')
    ->name('register');
Route::middleware(['auth'])->group(function () {
    Route::get('/',[HomeController::class, 'index'])->name('home');

});
