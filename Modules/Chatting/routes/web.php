<?php

use App\Events\MessageSent;
use Illuminate\Support\Facades\Route;
use Modules\Chatting\Http\Controllers\ChattingController;
use Modules\Chatting\Models\Message;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('chatting', ChattingController::class)->names('chatting');
});
Route::get('/test-message-event', function () {
    // Assuming you have a Message instance to broadcast
    $message = Message::create([
        'message' => 'Test message',
        'sender_id' => 1,  // You can use a real user ID here
        'receiver_id' => 2, // You can use a real receiver ID here
    ]);

    // Broadcasting the MessageSent event
    broadcast(new MessageSent($message));

    return response()->json(['message' => 'MessageSent event broadcasted!']);
});