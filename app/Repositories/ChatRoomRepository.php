<?php

namespace App\Repositories;

use App\Events\Chat\ChatRoomCreatedEvent;
use App\Models\ChatMember;
use App\Models\ChatRoom;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ChatRoomRepository
{
    public function create(Authenticatable $user, $roomType): ChatRoom
    {
        /** @var ChatRoom $room */
        $room = ChatRoom::query()
            ->create([
                'type' => $roomType,
            ]);

        $members = collect([
            [
                'user_table' => ChatMember::TABLE_USER,
                'user_id' => $user->id,
                'status' => ChatMember::STATUS_JOINED,
            ],
        ])->concat(
            $user->admins->map(fn ($admin) => [
                'user_table' => ChatMember::TABLE_ADMIN,
                'user_id' => $admin->id,
                'status' => ChatMember::STATUS_PENDING,
            ])
        );

        // Bulk insert members
        $room->members()->createMany($members);
        foreach ($room->members as $member) {
            ChatRoomCreatedEvent::dispatch($member->getUser(), $room);
        }

        return $room;
    }

}
