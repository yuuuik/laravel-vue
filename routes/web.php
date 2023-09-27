<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\api\UserController;


use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('home');
    Route::get('/about', [IndexController::class, 'about'])->name('about');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::post('/api/upload', [ArticleController::class, 'uploadImage'])->name('image.upload');

    Route::get('/token', function () {
        return csrf_token();
    });

    Route::get('/articles/indexCreate', [ArticleController::class, 'indexCreate'])->name('articles.indexCreate');
    Route::get('/articles/indexEdit/{id}', [ArticleController::class, 'indexEdit'])->name('articles.indexEdit');
    Route::put('/articles/update/{article}', [ArticleController::class, 'update'])->name('articles.update');


    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');





    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::resource('users', UserController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('categories', CategoryController::class);


});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::inertia('/login', 'Login');
