<?php

use Illuminate\Support\Facades\Route;

Route::middleware('isAdministrator')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/books', [App\Http\Controllers\HomeController::class, 'book'])->name('book');
    Route::get('/books/add', [App\Http\Controllers\HomeController::class, 'addBook'])->name('add-book');
    Route::get('/books/edit/{id}', [App\Http\Controllers\HomeController::class, 'editBook'])->name('edit-book');

    Route::get('/book-categories', [App\Http\Controllers\HomeController::class, 'bookCategories'])->name('book-categories');
    Route::get('/book-categories/{id}', [App\Http\Controllers\CategoryController::class, 'getCategoryByID'])->name('get-book-categories');
});

// Auth Routes
Auth::routes(['reset' => false]);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout'); 
