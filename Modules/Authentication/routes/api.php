<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\AuthenticationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('authentication', AuthenticationController::class)->names('authentication');
});
Route::prefix('v1')->group(function () {
    Route::post("/login", [AuthenticationController::class, 'postLogin'])->name('auth.login');
    Route::post("/sign-up", [AuthenticationController::class, 'postSignup'])->name('auth.register');

    // logout route protected by sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post("/logout", [AuthenticationController::class, 'postLogout'])->name('auth.logout');
    });
});

