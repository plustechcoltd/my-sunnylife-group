<?php

namespace App\Events\Chat;

use App\Models\ChatRoom;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRoomSeenAllEvent implements ShouldBroadcast, ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    private string $channel;
    public ChatRoom $room;
    public $user;

    public function __construct(ChatRoom $room)
    {
        $this->room = $room;
        $this->user = [
            'id' => auth()->user()->id,
            'user_table' => auth()->user()->getTable(),
        ];
        $this->channel = config('const.chat_room_prefix') . $room->id;
    }

    public function broadcastAs(): string
    {
        return config('const.chat_room_events.seen_all');
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel($this->channel);
    }
}
