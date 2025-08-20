<?php

namespace App\Broadcasting;

use App\Services\WebNotificationService;
use Illuminate\Notifications\Notification;

class UserWebChannel
{
    protected $notificationService;

    /**
     * Create a new channel instance.
     */
    public function __construct(WebNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notifiable, 'routeNotificationForWeb')) {
            throw new \Exception('Notifiable does not have routeNotificationForWeb method');
        }

        $to = $notifiable->routeNotificationForWeb($notification);
        $notificationDataBuilder = $notification->toWeb($notifiable);

        $this->notificationService->sendNotification($to, $notificationDataBuilder);
    }
}
