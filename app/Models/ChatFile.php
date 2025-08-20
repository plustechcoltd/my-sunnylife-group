<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chat_message_id',
        'file_name',
        'file_type',
        'file_path',
    ];

    public function chatMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'chat_message_id');
    }
}
