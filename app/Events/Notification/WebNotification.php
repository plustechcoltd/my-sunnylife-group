<?php

namespace App\Events\Notification;

use App\Helpers\UserHelper;
use App\Notifications\NotificationDataBuilder;
use Carbon\Carbon;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Database\Eloquent\Model as Notification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebNotification implements ShouldBroadcast, ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    private int $userId;
    private string $channel;
    private string $event;
    public object $notification;

    public function __construct(Authenticatable $user, Notification $notification, NotificationDataBuilder $builder)
    {
        $this->event = $builder->getEvent();
        $this->userId = $user->getAuthIdentifier();
        $this->notification = (object)$notification->getAttributes();
        $this->notification->created_at = $notification->created_at instanceof Carbon ? $notification->created_at : Carbon::parse($notification->created_at);
        $this->notification->message = $notification->message;
        $this->notification->redirect_url = $builder->getRouteName() ? route($builder->getRouteName(), $builder->getRouteData()) : null;
        $userType = UserHelper::getUserType($user);
        $this->channel = str_replace(
            '{id}',
            $this->userId,
            config('notification.notification_channels')[$userType]
        );
    }

    public function broadcastAs(): string
    {
        return $this->event;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel($this->channel);
    }
}
