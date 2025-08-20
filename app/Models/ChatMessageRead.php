<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessageRead extends Model
{
    use SoftDeletes;

    protected $table = 'chat_message_read';

    const NULL = null;
    const JOINED = 'joined';
    const LEAVED = 'left';
    const BLOCKED = 'blocked';

    protected $fillable = [
        'chat_message_id',
        'chat_member_id',
    ];

    public function chatMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'chat_message_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChatMember::class, 'chat_member_id');
    }
}
