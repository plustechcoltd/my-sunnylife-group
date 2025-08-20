<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    public const VIEW_AVATAR = 'viewAvatar';

    public function viewAvatar($loggedUser, Admin $admin): bool
    {
        if ($loggedUser instanceof Admin) {
            return $loggedUser->hasPermission('admin:admins') || $loggedUser->id === $admin->id;
        }

        return false;
    }
}
