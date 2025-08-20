<?php

namespace App\Models;

use App\Traits\ModelNotifiableTrait;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model implements NotificationInterface
{
    use ModelNotifiableTrait;

    protected $fillable = [
        'user_id',
        'category_type',
        'type',
        'read_yn',
        'route_name',
        'route_data',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'route_data' => 'array',
    ];

    protected $appends = ['is_read', 'redirect_url', 'message'];

    public function notificationObjects()
    {
        return $this->hasMany(UserNotificationObject::class, 'user_notification_id');
    }

    public function loadRelatedModels()
    {
        $groupedObjects = $this->notificationObjects->groupBy('record_model');

        foreach ($groupedObjects as $modelClass => $objects) {
            if (class_exists($modelClass)) {
                $ids = $objects->pluck('record_id')->unique();
                $query = $modelClass::whereIn('id', $ids)
                ->select('id');

                if ($modelClass === 'App\Models\User') {
                    $query->addSelect('first_name', 'family_name', 'email', 'allowed_ips');
                } elseif ($modelClass === 'App\Models\ActivityLog') {
                    $query->addSelect('ip_address');
                } elseif ($modelClass === 'App\Models\Admin') {
                    $query->addSelect('first_name', 'family_name');
                }

                $query->get()->each(function ($model) use ($objects) {
                    $objects->where('record_id', $model->id)
                        ->each(function ($object) use ($model) {
                            $object->loadedModel = $model;
                        });
                });
            }
        }

        return $groupedObjects;
    }

    public function getIsReadAttribute()
    {
        return $this->read_yn == 'y';
    }
}
