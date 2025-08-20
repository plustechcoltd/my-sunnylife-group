<?php

namespace App\Events\Chat;

use App\Helpers\UserHelper;
use App\Models\ChatRoom;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRoomCreatedEvent implements ShouldBroadcast, ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    private int $userId;
    private string $channel;
    private ChatRoom $room;
    public array $data;

    public function __construct(Authenticatable $user, ChatRoom $room)
    {
        $this->room = $room;
        $this->data = [
            'id' => $room->id,
            'name' => $room->name,
            'type' => $room->type,
        ];
        $this->userId = $user->getAuthIdentifier();
        $userType = UserHelper::getUserType($user);
        $this->channel = str_replace(
            '{id}',
            $this->userId,
            config('notification.notification_channels')[$userType]
        );
    }

    public function broadcastAs(): string
    {
        return config('const.chat_room_events.created');
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel($this->channel);
    }
}
