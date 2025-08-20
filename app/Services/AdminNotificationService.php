<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AdminNotification as Notification;
use App\Models\AdminNotificationObject as NotificationObject;
use App\Traits\ServiceNotifiableTrait;
use Illuminate\Database\Eloquent\Collection;

class AdminNotificationService implements NotificationServiceInterface
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
        return 'admin';
    }

    public function getAllReceives(): ?Collection
    {
        return Admin::all();
    }
}
