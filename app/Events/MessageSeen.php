<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSeen implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messageIds;
    public $readerId;
    public $readerType;

    public function __construct(array $messageIds, $readerType, $readerId)
    {
        $this->messageIds = $messageIds;
        $this->readerType = $readerType;
        $this->readerId = $readerId;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('chat.' . strtolower($this->readerType) . '.' . $this->readerId)];
    }

    public function broadcastWith(): array
    {
        return [
            'message_ids' => $this->messageIds,
            'reader_id' => $this->readerId,
            'reader_type' => strtolower($this->readerType),
        ];
    }
}
