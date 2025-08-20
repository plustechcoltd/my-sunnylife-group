<?php

namespace App\Services;

use App\Events\Chat\ChatRoomMessageEvent;
use App\Events\Chat\ChatRoomSeenAllEvent;
use App\Helpers\FileHelper;
use App\Helpers\UserHelper;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use App\Models\ChatMessageRead;
use App\Models\ChatRoom;
use App\Repositories\ChatRoomRepository;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatService
{
    protected ChatRoomRepository $chatRoomRepository;

    public function __construct(ChatRoomRepository $chatRoomRepository)
    {
        $this->chatRoomRepository = $chatRoomRepository;
    }

    public function create($user, $roomType): ChatRoom
    {
        return $this->chatRoomRepository->create($user, $roomType);
    }

    /**
     * @throws Exception
     */
    public function sendMessage(Authenticatable $user, ChatRoom $room, string $message): ChatMessage
    {
        /** @var ChatMember $member */
        $member = $room->members()
            ->where('user_table', $user->getTable())
            ->where('user_id', $user->getAuthIdentifier())->first();
        if (null === $member) {
            throw new Exception('User is not a member of the room');
        }

        /** @var ChatMessage $message */
        $message = $room->messages()->create([
            'chat_member_id' => $member->id,
            'message' => $message,
            'message_type' => ChatMessage::MESSAGE_TYPE_TEXT,
            'display_type' => ChatMessage::DISPLAY_TYPE_ALL,
        ]);

        $this->incrementUnreadCount($room, $user);

        ChatRoomMessageEvent::dispatch($room, $message);

        return $message;
    }

    public function incrementUnreadCount($room, $user)
    {
        // Update last message and last message at to subscriptions
        return $room->members()
            ->where(function ($q) use ($user) {
                $q->where('user_table', '!=', $user->getTable())
                    ->orWhere('user_id', '!=', $user->id);
            })
            ->increment('unread_count');
    }

    public function listMembers(): array
    {
        $result = [];
        $user = Auth::user();
        $userType = UserHelper::getUserType($user);

        $members = ChatMember::with([
            'room.members',
        ])
            ->where('user_table', $user->getTable())
            ->where('user_id', $user->id)
            ->leftJoin('chat_messages', function ($join) {
                $join->on('chat_members.chat_room_id', '=', 'chat_messages.chat_room_id')
                    ->whereRaw('chat_messages.created_at = (
                        SELECT MAX(created_at)
                        FROM chat_messages as m2
                        WHERE m2.chat_room_id = chat_members.chat_room_id
                    )');
            })
            ->orderBy('chat_messages.created_at', 'desc')
            ->select('chat_members.*')
            ->get();

        foreach ($members as $member) {
            $room = $member->room;

            if ($this->shouldIgnoreRoom($userType, $room, $user)) {
                continue;
            }

            if (!empty($result[$member->id])) {
                continue;
            }

            $result[$member->id] = [
                'id' => $member->id,
                'name' => $member->room->name,
                'user_table' => $member->user_table,
                'user_id' => $member->user_id,
                'room' => [
                    'id' => $room->id,
                    'type' => $room->type,
                    'members' => $room->members->map(function ($member) use ($user) {
                        return [
                            'id' => $member->id,
                            'user_table' => $member->user_table,
                            'user_id' => $member->user_id,
                            'full_name' => $member->getUser()->full_name,
                            'avatar' => $member->getMemberAvatarUrl(),
                            'status' => $member->status,
                        ];
                    }),
                    'avatar' => $room->getAvatar(),
                    'name' => $room->getName(),
                    'created_at' => $room->created_at,
                    'private_key' => $room->private_key,
                ],
                'unread_count' => $member->unread_count,
                'last_message' => ($lastMessage = $member->lastMessage()) ? [
                    'id' => $lastMessage->id,
                    'chat_member_id' => $lastMessage->chat_member_id,
                    'message' => $lastMessage->message,
                    'extra_data' => $lastMessage->extra_data,
                    'message_type' => $lastMessage->message_type,
                    'created_at' => $lastMessage->created_at,
                ] : null,
            ];
        }

        return array_values($result);
    }

    /**
     * @throws Exception
     */
    public function markAsRead(Authenticatable $user, ChatRoom $room, ChatMessage $lastMessage = null): void
    {
        $member = $room->members()
            ->where('chat_room_id', $room->id)
            ->where('user_table', $user->getTable())
            ->where('user_id', $user->getAuthIdentifier())
            ->first();
        if (null === $member) {
            throw new Exception('User is not a member of the room');
        }

        $dataUpdate['unread_count'] = 0;
        if ($lastMessage) {
            ChatMessageRead::firstOrCreate([
                'chat_message_id' => $lastMessage->id,
                'chat_member_id' => $member->id,
            ]);
            $dataUpdate['last_read_chat_message_id'] = $lastMessage->id;
            $member->update($dataUpdate);
            return;
        } else {
            $member->update($dataUpdate);
        }

        // mark all as read
        ChatRoomSeenAllEvent::dispatch($room);
        $messages = $room->messages()->whereNot('chat_member_id', $member->id);
        if ($lastReadMessage = ChatMessage::find($member->last_read_chat_message_id)) {
            $messages = $messages->where('created_at', '>=', $lastReadMessage->created_at);
        }
        $messages = $messages->get();

        $chatMessageReads = [];
        foreach ($messages as $message) {
            $chatMessageReads[] = [
                'chat_message_id' => $message->id,
                'chat_member_id' => $member->id,
            ];
        }
        if (!empty($chatMessageReads)) {
            DB::table('chat_message_read')->insertOrIgnore($chatMessageReads);
        }
    }

    public function getLatestChatRoomId($userTable): ?int
    {
        $userId = Auth::id();
        $userType = UserHelper::getUserType(Auth::user());

        $chatRooms = ChatMember::query()
            ->where('user_table', $userTable)
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($chatRooms as $chatMember) {
            $room = $chatMember->room;

            if ($this->shouldIgnoreRoom($userType, $room, auth()->user())) {
                continue;
            }

            return $room->id;
        }

        return null;
    }

    // Check if a chat room should be ignored based on the user type and the status of other members
    public function shouldIgnoreRoom(string $userType, ChatRoom $room, $user): bool
    {
        if ($userType === config('const.user_types.user')) {
            $otherMembers = $room->members->filter(function ($m) use ($user) {
                return $m->user_id !== $user->id || $m->user_table !== $user->getTable();
            });

            if ($otherMembers->every(fn ($m) => $m->status === ChatMember::STATUS_PENDING)) {
                return true;
            }
        }

        return false;
    }

    public function injectSystemMessage(
        ChatRoom $room,
        $message,
        string $messageType,
        string $displayType = 'all',
        array $extraData = null
    ): void {
        $chatMessage = $room->messages()->create([
            'chat_member_id' => null,
            'message_type' => $messageType,
            'message' => $message,
            'extra_data' => $extraData,
            'display_type' => $displayType,
        ]);

        $this->incrementUnreadCount($room, auth()->user());

        ChatRoomMessageEvent::dispatch($room, $chatMessage);
    }

    public function sendMessageWithFile(Authenticatable $user, ChatRoom $room, array $data)
    {
        /** @var ChatMember $member */
        $member = $room->members()
            ->where('user_table', $user->getTable())
            ->where('user_id', $user->getAuthIdentifier())->first();
        if (null === $member) {
            throw new Exception('User is not a member of the room');
        }

        // Store the file
        $file = $data['file'];
        $filePath = FileHelper::processFileUpload($file, 'filesystems.paths.chat.file');
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getClientMimeType();

        /** @var ChatMessage $message */
        $message = $room->messages()->create([
            'chat_member_id' => $member->id,
            'message' => $data['message'],
            'message_type' => ChatMessage::MESSAGE_TYPE_FILE,
            'display_type' => ChatMessage::DISPLAY_TYPE_ALL,
        ]);

        // Create a chat file
        $message->chatFile()->create([
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
        ]);

        $this->incrementUnreadCount($room, auth()->user());

        // Broadcast the message
        ChatRoomMessageEvent::dispatch($room, $message);

        return $message;
    }
}
