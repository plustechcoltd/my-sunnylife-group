<?php

use App\Models\Admin;
use App\Models\ChatMember;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(config('notification.notification_channels.admin'), function ($user, $id) {
    return $user instanceof Admin && $user->id === (int) $id;
}, ['guards' => ['admin']]);

Broadcast::channel(config('notification.notification_channels.user'), function ($user, $id) {
    return $user instanceof User && $user->id === (int) $id;
}, ['guards' => ['user']]);

Broadcast::channel(config('const.chat_room_prefix').'{id}', function ($user, $id) {
    $userTable = $user->getTable();

    $member = ChatMember::query()
        ->where('user_table', $userTable)
        ->where('user_id', $user->id)
        ->where('chat_room_id', $id)
        ->first();
    if (!$member) {
        return false;
    }
    return [
        // 'id' => $member->id,
        'id' => $member->user_table . '_' . $member->user_id,
        'user_table' => $member->user_table,
        'user_id' => $member->user_id,
        'full_name' => $user->full_name,
        'active_room_id' => $id,
    ];
}, ['guards' => ['admin', 'user']]);

Broadcast::channel('online', function ($user) {
    $activeRoomId = request()->header('X-Active-Room-Id');
    $userTable = $user->getTable();

    return [
        'id' => $userTable . '_' . $user->id,
        'user_table' => $userTable,
        'user_id' => $user->id,
        'full_name' => $user->full_name,
        'active_room_id' => $activeRoomId,
    ];
}, ['guards' => ['admin', 'user']]);
