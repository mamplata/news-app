<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    // Route for displaying the dashboard with the list of news
    Route::get('/dashboard', [NewsController::class, 'index'])->name('dashboard');

    // Routes for creating, storing, editing, updating, and deleting news
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create'); // Display the form to create a news post
    Route::post('/news', [NewsController::class, 'store'])->name('news.store'); // Store a new news post

    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit'); // Edit an existing news post
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update'); // Update an existing news post

    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy'); // Delete a news post
});

Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
