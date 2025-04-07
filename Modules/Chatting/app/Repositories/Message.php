<?php

namespace Modules\Chatting\Repositories;

use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Modules\Chatting\Models\Message as ModelsMessage;

class Message
{
    public function handle() {}

    public function getMessages()
     {
        return ModelsMessage::with('user')->get();
    }

    public function postMessage(array $data)
    {
       $messages =  ModelsMessage::create([
            'message' => $data['message'],
            'user_id' => Auth::user()->id,
        ]);
        broadcast( new MessageSent($messages))->toOthers();
        return $messages;
    }

}
