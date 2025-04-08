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
       if(!Auth::check())
       {
          throw new \Exception('You are not Authenticated');
       }

      $messages =  Message::create([
           'message' => $data['message'],
           'sender_id' => Auth::user()->id,
           'receiver_id' => $data['receiver_id'],
       ]);
       event(new MessageSent($messages));

       broadcast( new MessageSent($messages))->toOthers();
       return $messages;
   }
}
