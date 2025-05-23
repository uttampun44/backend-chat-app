<?php

use Illuminate\Support\Facades\Route;
use Modules\Chatting\Http\Controllers\ChattingController;
use Modules\Chatting\Http\Controllers\HomeController;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('chatting', ChattingController::class)->only(['index', 'store']);
        Route::resource('users-list', HomeController::class)->only(['index']);
    });
});
