<?php

namespace App\Events\Chat;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRoomMessageEvent implements ShouldBroadcast, ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    private string $channel;
    private ChatRoom $room;
    private ChatMessage $message;
    public array $encryptedMessage;
    public string $roomId;

    public function __construct(ChatRoom $room, ChatMessage $message)
    {
        $this->room = $room;
        $this->roomId = $room->id;
        $message->load(['member', 'chatMessageReads', 'chatFile']);
        $this->message = $message;
        $this->encryptedMessage = $room->encryptedMessage($message);
        $this->channel = config('const.chat_room_prefix').$room->id;
    }

    public function broadcastAs(): string
    {
        return config('const.chat_room_events.message');
    }

    public function broadcastOn()
    {
        return [new PrivateChannel($this->channel), new PresenceChannel('online')];
    }
}
