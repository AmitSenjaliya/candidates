<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['check.guest'])->group(function () {
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLoginForm']);
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
});

Route::middleware(['check.token'])->group(function () {
    Route::post('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // Author routes
    Route::get('/authors', [App\Http\Controllers\Author\AuthorController::class, 'index'])->name('authors');
    Route::delete('/authors/{id}', [App\Http\Controllers\Author\AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::get('/authors/{id}', [App\Http\Controllers\Author\AuthorController::class, 'view'])->name('authors.view');

    // Books Route
    Route::get('/books/create', [App\Http\Controllers\Book\BookController::class, 'create'])->name('books.create');
    Route::post('/books', [App\Http\Controllers\Book\BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{id}', [App\Http\Controllers\Book\BookController::class, 'destroy'])->name('books.destroy');
});