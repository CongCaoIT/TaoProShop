<?php

use App\Http\Controllers\Administrator\AuthController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\LanguageController;
use App\Http\Controllers\Administrator\PostCatalogueController;
use App\Http\Controllers\Administrator\PostController;
use App\Http\Controllers\Administrator\UserCatalogueController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboard;
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

/* User Catalogue */
Route::group(['prefix' => 'user/catalogue'], function () {
    Route::get('', [UserCatalogueController::class, 'index'])->name('user.catalogue.index')->middleware(EnsureTokenIsValid::class);
    Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create')->middleware(EnsureTokenIsValid::class);
    Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store')->middleware(EnsureTokenIsValid::class);
    Route::get('edit/{id}', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit')->middleware(EnsureTokenIsValid::class);
    Route::post('update/{id}', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update')->middleware(EnsureTokenIsValid::class);
    Route::get('delete/{id}', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete')->middleware(EnsureTokenIsValid::class);
    Route::post('destroy/{id}', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy')->middleware(EnsureTokenIsValid::class);
});

/* Languages */
Route::group(['prefix' => 'language'], function () {
    Route::get('', [LanguageController::class, 'index'])->name('language.index')->middleware(EnsureTokenIsValid::class);
    Route::get('create', [LanguageController::class, 'create'])->name('language.create')->middleware(EnsureTokenIsValid::class);
    Route::post('store', [LanguageController::class, 'store'])->name('language.store')->middleware(EnsureTokenIsValid::class);
    Route::get('edit/{id}', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit')->middleware(EnsureTokenIsValid::class);
    Route::post('update/{id}', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('language.update')->middleware(EnsureTokenIsValid::class);
    Route::get('delete/{id}', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete')->middleware(EnsureTokenIsValid::class);
    Route::post('destroy/{id}', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('language.destroy')->middleware(EnsureTokenIsValid::class);
});

/* Post Catalogue */
Route::group(['prefix' => 'post/catalogue'], function () {
    Route::get('', [PostCatalogueController::class, 'index'])->name('post.catalogue.index')->middleware(EnsureTokenIsValid::class);
    Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create')->middleware(EnsureTokenIsValid::class);
    Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store')->middleware(EnsureTokenIsValid::class);
    Route::get('edit/{id}', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit')->middleware(EnsureTokenIsValid::class);
    Route::post('update/{id}', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update')->middleware(EnsureTokenIsValid::class);
    Route::get('delete/{id}', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete')->middleware(EnsureTokenIsValid::class);
    Route::post('destroy/{id}', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy')->middleware(EnsureTokenIsValid::class);
});

/* Posts */
Route::group(['prefix' => 'post'], function () {
    Route::get('', [PostController::class, 'index'])->name('post.index')->middleware(EnsureTokenIsValid::class);
    Route::get('create', [PostController::class, 'create'])->name('post.create')->middleware(EnsureTokenIsValid::class);
    Route::post('store', [PostController::class, 'store'])->name('post.store')->middleware(EnsureTokenIsValid::class);
    Route::get('edit/{id}', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit')->middleware(EnsureTokenIsValid::class);
    Route::post('update/{id}', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update')->middleware(EnsureTokenIsValid::class);
    Route::get('delete/{id}', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete')->middleware(EnsureTokenIsValid::class);
    Route::post('destroy/{id}', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy')->middleware(EnsureTokenIsValid::class);
});

/* Ajax */
Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index')->middleware(EnsureTokenIsValid::class);
Route::post('ajax/dashboard/changeStatus', [AjaxDashboard::class, 'changeStatus'])->name('ajax.dashboard.changeStatus')->middleware(EnsureTokenIsValid::class);
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboard::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll')->middleware(EnsureTokenIsValid::class);

/* Login */
Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
