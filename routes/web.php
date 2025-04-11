<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [MessageController::class, 'inbox'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/message/{user}', [MessageController::class, 'store'])->name('message.store')->middleware(['auth', 'verified']);
Route::get('/message/{user}', [MessageController::class, 'show'])->name('message.show')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [ChatController::class, 'index'])->name('users');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
});

require __DIR__ . '/auth.php';
