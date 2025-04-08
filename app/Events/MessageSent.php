<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Chatting\Models\Message;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiver_id;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        logger('MessageSent event fired');
        $this->message = $message;
        $this->receiver_id = $message->receiver_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    //  only authenticate user will receive message
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->message->receiver_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'created_at' => $this->message->created_at,
        ];
    }
}
