<?php

use Illuminate\Support\Facades\Route;

Route::middleware('isAdministrator')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [App\Http\Controllers\HomeController::class, 'book'])->name('book');
    Route::get('/books/add', [App\Http\Controllers\HomeController::class, 'addBook'])->name('add-book');
    Route::get('/book-categories', [App\Http\Controllers\HomeController::class, 'bookCategories'])->name('book-categories');
});

// Auth Routes
Auth::routes(['reset' => false]);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout'); 
