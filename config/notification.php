<?php

return [
    // Notification
    'notification_channels' => [
        'admin' => 'admin.{id}',
        'user' => 'user.{id}',
    ],
    'notification_events' => [
        'admin' => [
            'web_notification' => 'web_notification',
        ],
        'user' => [
            'web_notification' => 'web_notification',
        ],
    ],
];
