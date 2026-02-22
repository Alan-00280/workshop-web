<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('isAdministrator')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/books', [App\Http\Controllers\HomeController::class, 'book'])->name('book');
    Route::get('/books/add', [App\Http\Controllers\HomeController::class, 'addBook'])->name('add-book');
    Route::get('/books/edit/{id}', [App\Http\Controllers\HomeController::class, 'editBook'])->name('edit-book');
    Route::post('/books/add', [App\Http\Controllers\BukuController::class, 'createBuku'])->name('create-book');
    Route::patch('/books/edit', [App\Http\Controllers\BukuController::class, 'updateBuku'])->name('update-book');
    Route::delete('/books/delete/{id}', [App\Http\Controllers\BukuController::class, 'deleteBuku'])->name('delete-book');

    Route::get('/book-categories', [App\Http\Controllers\HomeController::class, 'bookCategories'])->name('book-categories');
    Route::post('/book-categories/add', [App\Http\Controllers\CategoryController::class, 'createCateory'])->name('create-book-categories');
    Route::patch('/book-categories/edit', [App\Http\Controllers\CategoryController::class, 'editCategory'])->name('edit-book-categories');
    Route::delete('/book-categories/delete/{id}', [App\Http\Controllers\CategoryController::class, 'deleteCategory'])->name('delete-book-categories');
    Route::get('/book-categories/get/{id}', [App\Http\Controllers\CategoryController::class, 'getCategoryByID'])->name('get-book-categories');
    });

// Auth Routes
Auth::routes(['reset' => false]);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google-login-redirect');
Route::get('/auth/google/cb', [GoogleController::class, 'callback']);


Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'show']);
    Route::post('/verify-otp', [OtpController::class, 'verify']);
});
