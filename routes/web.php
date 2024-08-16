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
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => [AuthenticateMiddleware::class, SetLocale::class]], function () {
    /* Administrator */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /* User */
    Route::group(['prefix' => 'user'], function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
        Route::post('update/{id}', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
        Route::get('delete/{id}', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
        Route::post('destroy/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
    });

    /* User Catalogue */
    Route::group(['prefix' => 'user/catalogue'], function () {
        Route::get('', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
        Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
        Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
        Route::get('edit/{id}', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
        Route::post('update/{id}', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update');
        Route::get('delete/{id}', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
        Route::post('destroy/{id}', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
    });

    /* Languages */
    Route::group(['prefix' => 'language'], function () {
        Route::get('', [LanguageController::class, 'index'])->name('language.index');
        Route::get('create', [LanguageController::class, 'create'])->name('language.create');
        Route::post('store', [LanguageController::class, 'store'])->name('language.store');
        Route::get('edit/{id}', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit');
        Route::post('update/{id}', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('language.update');
        Route::get('delete/{id}', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete');
        Route::post('destroy/{id}', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('language.destroy');
        Route::get('switch/{id}', [LanguageController::class, 'switchLanguage'])->where(['id' => '[0-9]+'])->name('language.switch');
    });

    /* Post Catalogue */
    Route::group(['prefix' => 'post/catalogue'], function () {
        Route::get('', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
        Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
        Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
        Route::get('edit/{id}', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
        Route::post('update/{id}', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update');
        Route::get('delete/{id}', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
        Route::post('destroy/{id}', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
    });

    /* Posts */
    Route::group(['prefix' => 'post'], function () {
        Route::get('', [PostController::class, 'index'])->name('post.index');
        Route::get('create', [PostController::class, 'create'])->name('post.create');
        Route::post('store', [PostController::class, 'store'])->name('post.store');
        Route::get('edit/{id}', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
        Route::post('update/{id}', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update');
        Route::get('delete/{id}', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
        Route::post('destroy/{id}', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
    });

    /* Ajax */
    Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index');
    Route::post('ajax/dashboard/changeStatus', [AjaxDashboard::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
    Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboard::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');
});

/* Login */
Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
