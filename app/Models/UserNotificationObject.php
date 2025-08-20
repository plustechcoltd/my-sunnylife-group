<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationObject extends Model
{
    protected $fillable = [
        'user_notification_id',
        'record_model',
        'record_id',
    ];

    public function notification()
    {
        return $this->belongsTo(UserNotification::class);
    }

    public function relatedModel()
    {
        return $this->morphTo('record_model', 'record_model', 'record_id');
    }

    public function getRelatedModelAttribute()
    {
        return $this->record_model;
    }
}
