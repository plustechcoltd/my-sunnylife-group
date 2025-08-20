<?php

namespace App\Services;

use App\Notifications\NotificationDataBuilder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

interface NotificationServiceInterface
{
    public function notificationModel();

    public function notificationObjectModel();

    public function getIdField();

    public function getAllReceives(): ?Collection;

    public function sendNotificationsToAll(NotificationDataBuilder $builder): void;

    public function sendNotification(Authenticatable $user, NotificationDataBuilder $builder);

    public function markAllAsRead(Authenticatable $user): void;

    public function markAsRead(Authenticatable $user, $notification): void;
}
