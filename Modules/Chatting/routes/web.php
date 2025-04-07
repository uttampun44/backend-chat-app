<?php

use Illuminate\Support\Facades\Route;
use Modules\Chatting\Http\Controllers\ChattingController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('chatting', ChattingController::class)->names('chatting');
});
