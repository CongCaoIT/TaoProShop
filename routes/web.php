<?php

use App\Http\Controllers\Administrator\AuthController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* Administrator */
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(EnsureTokenIsValid::class);

/* User */
Route::get('user', [UserController::class, 'index'])->name('user.index')->middleware(EnsureTokenIsValid::class);

Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
