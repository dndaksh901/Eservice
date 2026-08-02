<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        $receiverType = class_basename($this->message->receiver_type); // User or Vendor
        $receiverId = $this->message->receiver_id;

        return [
            new PrivateChannel('chat.' . strtolower($receiverType) . '.' . $receiverId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => array_merge($this->message->toArray(), [
                'sender_name' => optional($this->message->sender)->name,
                'receiver_name' => optional($this->message->receiver)->name,
            ]),
        ];
    }
}
