<?php

use Illuminate\Support\Facades\Route;

Route::middleware('isAdministrator')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/books', [App\Http\Controllers\HomeController::class, 'book'])->name('book');
    Route::get('/books/add', [App\Http\Controllers\HomeController::class, 'addBook'])->name('add-book');
    Route::get('/books/edit/{id}', [App\Http\Controllers\HomeController::class, 'editBook'])->name('edit-book');
    Route::post('/books/add', [App\Http\Controllers\BukuController::class, 'createBuku'])->name('create-book');
    Route::patch('/books/edit', [App\Http\Controllers\BukuController::class, 'updateBuku'])->name('update-book');
    Route::delete('/books/delete/{id}', [App\Http\Controllers\BukuController::class, 'deleteBuku'])->name('delete-book');

    Route::get('/book-categories', [App\Http\Controllers\HomeController::class, 'bookCategories'])->name('book-categories');
    Route::get('/book-categories/{id}', [App\Http\Controllers\CategoryController::class, 'getCategoryByID'])->name('get-book-categories');
});

// Auth Routes
Auth::routes(['reset' => false]);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout'); 
