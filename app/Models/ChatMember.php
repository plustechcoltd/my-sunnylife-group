<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMember extends Model
{
    use SoftDeletes;

    const STATUS_PENDING = 'pending';
    const STATUS_JOINED = 'joined';
    const STATUS_LEFT = 'left';

    const TABLE_USER = User::TABLE_NAME;
    const TABLE_ADMIN = Admin::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_room_id',
        'user_table',
        'user_id',
        'status',
        'unread_count',
        'last_read_chat_message_id',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    public function getUser(): Authenticatable
    {
        if ($this->user_table === self::TABLE_ADMIN) {
            return Admin::query()->find($this->user_id);
        } else {
            return User::query()->find($this->user_id);
        }
    }

    public function lastReadMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'last_read_chat_message_id');
    }

    public function lastMessage()
    {
        return $this->room->messages()->latest()->first();
    }

    public function getMemberAvatarUrl(): string
    {
        return match ($this->user_table) {
            ChatMember::TABLE_ADMIN => route(
                'admin.admins.show_avatar',
                ['admin' => $this->getUser()->id]
            ),
            ChatMember::TABLE_USER => route(
                'web.users.show_avatar',
                ['user' => $this->getUser()->id]
            ),
            default => null,
        };
    }
}
