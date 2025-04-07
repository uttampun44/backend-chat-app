<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Chatting\Models\Message;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
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
            new PrivateChannel('App.Models.User.' . $this->message->user_id),
        ];
    }

    public function broadCastWith()
    {
        return [
            'message' => $this->message->message,
            'user_id' => $this->message->user_id,
            'created_at' => $this->message->created_at,
        ];
    }
}
