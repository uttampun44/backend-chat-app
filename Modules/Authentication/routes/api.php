<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\AuthenticationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('authentication', AuthenticationController::class)->names('authentication');
});
Route::prefix('v1')->group(function () {
    Route::post("/login", [AuthenticationController::class, 'postLogin'])->name('auth.login');
    Route::post("/sign-up", [AuthenticationController::class, 'postSignup'])->name('auth.register');
    Route::post("/email-confirmation", [AuthenticationController::class, 'postEmailConfirmation'])->name('auth.email-confirmation');
    Route::post("/otp", [AuthenticationController::class, 'postOtp'])->name('auth.otp');
    Route::post("/reset-password", [AuthenticationController::class, 'postResetPassword'])->name('auth.reset-password');
    // logout route protected by sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post("/logout", [AuthenticationController::class, 'postLogout'])->name('auth.logout');
    });
});

