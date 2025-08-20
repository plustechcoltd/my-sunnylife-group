<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Model;

class NotificationDataBuilder
{
    public function __construct(
        private readonly Model $notifiable,
        private readonly string $holder,
        private readonly string $category,
        private readonly string $action_to_receiver,
        private readonly array $data,
    ) {
    }

    public function getEvent(): string
    {
        return config('notification.notification_events.user.web_notification');
    }

    public function getHolder(): string
    {
        return $this->holder;
    }

    public function getCategoryType(): string
    {
        return $this->category;
    }

    public function getType(): string
    {
        return $this->action_to_receiver;
    }

    public function getModelId()
    {
        return $this->notifiable->id;
    }

    public function getNotificationObjects(): array
    {
        return $this->data['notification_objects'];
    }

    public function getRouteName(): string|null
    {
        return $this->data['route_name'] ?? null; // 'web.users.show_avatar'
    }

    public function getRouteData(): array
    {
        // [
        //     'user' => $this->notifiable->id,
        // ]
        return $this->data['route_data'] ?? null;
    }
}
