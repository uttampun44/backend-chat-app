<?php

use Illuminate\Support\Facades\Route;
use Modules\Chatting\Http\Controllers\ChattingController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('chatting', ChattingController::class)->only(['index', 'store']);
});
