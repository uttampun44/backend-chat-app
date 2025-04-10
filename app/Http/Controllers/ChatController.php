<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Modules\Chatting\Models\Message;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $auth_user = Auth::user();
        $users = $auth_user->users->where('id', '!=', $auth_user->id);
        return Inertia::render('Chat/User', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        // Get the current authenticated user
        $auth_user = Auth::user();
        
        // Retrieve the user that is being selected to chat with
        $receiver = User::find($id);
    
        // Make sure the receiver is not the authenticated user
        if (!$receiver || $receiver->id === $auth_user->id) {
            return redirect()->route('chat.index');
        }
    
        // Return the Chat page view with the receiver and the user's list of conversations
        return Inertia::render('Chat/ChatUser', [
            'users' => $auth_user->users,
            'receiver' => $receiver, // Pass the receiver
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            if(!Auth::check())
            {
               throw new \Exception('You are not Authenticated');
            }
            $data = $request->all();

           $messages =  Message::create([
                'message' => $data['message'],
                'sender_id' => Auth::user()->id,
                'receiver_id' => $data['receiver_id'],
            ]);
            event(new MessageSent($messages));
     
            broadcast( new MessageSent($messages))->toOthers();
            return $messages;
        }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    
}
