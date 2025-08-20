<?php

namespace App\Services;

use App\Models\UserNotification as Notification;
use App\Models\UserNotificationObject as NotificationObject;
use App\Traits\ServiceNotifiableTrait;
use Illuminate\Database\Eloquent\Collection;

class WebNotificationService implements NotificationServiceInterface
{
    use ServiceNotifiableTrait;

    public function notificationModel(): Notification
    {
        return new Notification();
    }

    public function notificationObjectModel(): NotificationObject
    {
        return new NotificationObject();
    }

    public function getIdField(): string
    {
        return 'user';
    }

    public function getAllReceives(): ?Collection
    {
        return null;
    }
}
