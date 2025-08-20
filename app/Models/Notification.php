<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_type',
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $hidden = [
        'user_type',
        'user_id',
        'updated_at',
        'deleted_at',
    ];
}
