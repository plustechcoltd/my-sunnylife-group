<?php

namespace App\Helpers;

use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;

class UserHelper
{
    public static function getUserType(Authenticatable $user)
    {
        return match (get_class($user)) {
            Admin::class => config('const.user_types.admin'),
            default => config('const.user_types.user'),
        };
    }

    public static function getAuthTable(Authenticatable $user)
    {
        return match (get_class($user)) {
            Admin::class => config('const.auth_tables.admin'),
            default => config('const.auth_tables.user'),
        };
    }
}
