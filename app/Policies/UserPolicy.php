<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class UserPolicy
{
    public const VIEW_AVATAR = 'viewAvatar';

    public function viewAvatar($loggedUser, User $user): bool
    {
        if ($loggedUser instanceof Admin) {
            return $loggedUser->hasPermission('admin:users');
        } elseif ($loggedUser instanceof User) {
            return $loggedUser->id === $user->id;
        }

        return false;
    }
}
