<?php

use Illuminate\Support\Facades\Route;

Route::middleware('isAdministrator')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    
});

// Auth Routes
Auth::routes(['reset' => false]);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout'); 
