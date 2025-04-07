<?php

namespace Modules\Chatting\Repositories;

use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Modules\Chatting\Models\Message;

class MessageRepository
{
    public function handle() {}

    public function getMessages()
    {
       return Message::with('user')->get();
   }

   public function postMessage(array $data)
   {
      $messages =  Message::create([
           'message' => $data['message'],
           'user_id' => Auth::user()->id,
       ]);
       broadcast( new MessageSent($messages))->toOthers();
       return $messages;
   }
}
