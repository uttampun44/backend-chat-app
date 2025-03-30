<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\AuthenticationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('authentication', AuthenticationController::class)->names('authentication');
});
Route::post("v1/sign-up", [AuthenticationController::class, 'postSignup'])->name('auth.register');

