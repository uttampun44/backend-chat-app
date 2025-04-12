<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Modules\Chatting\Models\Message;

class MessageController extends Controller
{
    public function inbox()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return Inertia::render('Dashboard', ['users' => $users]);
    }

    public function store(Request $request, User $user)
    {
      try {
        Log::error($request->all());
        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $user->id;
        $message->message = $request->message;
        $message->save();

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
      } catch (\Throwable $th) {
        Log::error($th);
        return response()->json(['message' => $th->getMessage()], 500);
      }
    }

    public function show(User $user)
    {
        $user1Id = Auth::user()->id;
        $user2Id = $user->id;

        $messages = Message::where(function ($query) use ($user1Id, $user2Id) {
            $query->where('sender_id', $user1Id)
                ->where('receiver_id', $user2Id);
        })
            ->orWhere(function ($query) use ($user1Id, $user2Id) {
                $query->where('sender_id', $user2Id)
                    ->where('receiver_id', $user1Id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
