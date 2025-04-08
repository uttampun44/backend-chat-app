<?php

use Illuminate\Support\Facades\Route;
use Modules\Chatting\Http\Controllers\ChattingController;

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('chatting', ChattingController::class)->only(['index', 'store']);
    });
});
