<?php

namespace App\Models;

interface NotificationInterface
{
    public function notificationObjects();
    public function loadRelatedModels();
    public function getIsReadAttribute();
    public function getRedirectUrlAttribute();
    public function getMessageAttribute();
    public function simplifyNotificationObjects();
}
