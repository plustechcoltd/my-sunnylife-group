<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use SoftDeletes;

    const DISPLAY_TYPE_ALL = 'all';
    const DISPLAY_TYPE_USER = 'user';
    const DISPLAY_TYPE_ADMIN = 'admin';

    const MESSAGE_TYPE_TEXT = 'text';
    const MESSAGE_TYPE_FILE = 'file';
    const MESSAGE_TYPE_TODO = 'todo';
    const MESSAGE_TYPE_USER_ACTION = 'user_action';
    const MESSAGE_TYPE_STATUS = 'status';
    const MESSAGE_TYPE_HELP = 'help';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_room_id',
        'chat_member_id',
        'message_type',
        'message',
        'extra_data',
        'display_type',
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChatMember::class, 'chat_member_id');
    }

    public function chatMessageReads()
    {
        return $this->hasMany(ChatMessageRead::class);
    }
    
    public function chatFile(): HasOne
    {
        return $this->hasOne(ChatFile::class, 'chat_message_id');
    }
}
