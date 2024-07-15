<?php

use App\Http\Controllers\Administrator\AuthController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Ajax\LocationController;
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
Route::group(['prefix' => 'user'], function () {
    Route::get('', [UserController::class, 'index'])->name('user.index')->middleware(EnsureTokenIsValid::class);
    Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(EnsureTokenIsValid::class);
    Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware(EnsureTokenIsValid::class);
    Route::get('edit/{id}', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit')->middleware(EnsureTokenIsValid::class);
    Route::post('update/{id}', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update')->middleware(EnsureTokenIsValid::class);
    Route::get('delete/{id}', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete')->middleware(EnsureTokenIsValid::class);
    Route::post('destroy/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy')->middleware(EnsureTokenIsValid::class);
});

/* Ajax */
Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index')->middleware(EnsureTokenIsValid::class);

Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
