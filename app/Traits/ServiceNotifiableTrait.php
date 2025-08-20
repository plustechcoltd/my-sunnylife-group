<?php

namespace App\Traits;

use App\Events\Notification\WebNotification;
use App\Notifications\NotificationDataBuilder;
use Illuminate\Contracts\Auth\Authenticatable;

trait ServiceNotifiableTrait
{
    public function sendNotificationsToAll(NotificationDataBuilder $builder): void
    {
        $users = $this->getAllReceives();
        foreach ($users as $user) {
            $this->sendNotification($user, $builder);
        }
    }

    public function sendNotification(Authenticatable $user, NotificationDataBuilder $builder)
    {
        $notification = $this->notificationModel()->create([
            $this->getIdField() . '_id' => $builder->getModelId(),
            'category_type' => $builder->getHolder() . "." . $builder->getCategoryType(),
            'type' => $builder->getType(),
            'read_yn' => 'n',
        ]);

        $notification_objects = $builder->getNotificationObjects();
        foreach ($notification_objects as $notification_object_item) {
            $this->notificationObjectModel()->create([
                $this->getIdField() . '_notification_id' => $notification->id,
                'record_model' => get_class($notification_object_item),
                'record_id' => $notification_object_item->id,
            ]);
        }

        $notification->loadRelatedModels();
        
        // Broadcast the notification to client
        WebNotification::dispatch($user, $notification, $builder);

        return $notification;
    }

    public function markAllAsRead(Authenticatable $user): void
    {
        $this->notificationModel()::query()
            ->where($this->getIdField() . '_id', $user->getAuthIdentifier())
            ->update(['read_yn' => 'y']);
    }

    public function markAsRead(Authenticatable $user, $notification): void
    {
        $this->notificationModel()::query()
            ->where($this->getIdField() . '_id', $user->getAuthIdentifier())
            ->where('id', $notification->id)
            ->update(['read_yn' => 'y']);
    }
}
