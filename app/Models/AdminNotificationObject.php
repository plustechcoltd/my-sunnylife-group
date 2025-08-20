<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotificationObject extends Model
{
    protected $fillable = [
        'admin_notification_id',
        'record_model',
        'record_id',
    ];

    public function notification()
    {
        return $this->belongsTo(AdminNotification::class);
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
