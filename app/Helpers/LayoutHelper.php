<?php

use App\Models\ChatMember;

if (!function_exists('getContainerClass')) {
    function getContainerClass($settings): string
    {
        return 'y' == !empty($settings['boxed_page']) ? 'container' : 'container-fluid';
    }
}

if (!function_exists('translateWithLocale')) {
    function translateWithLocale(string $firstKey, string $secondKey): string
    {
        $locale = app()->getLocale();

        if ($locale === 'ja') {
            return __('label.tables.'.$secondKey).__('label.labels.'.$firstKey);
        }

        return __('label.labels.'.$firstKey).' '.__('label.tables.'.$secondKey);
    }
}

if (!function_exists('getUserChatStatus')) {
    function getUserChatStatus($chatRoomId)
    {
        $user = Auth::user();
        $chatMember = ChatMember::where('chat_room_id', $chatRoomId)
            ->where('user_table', $user->getTable())
            ->where('user_id', $user->getAuthIdentifier())
            ->first();

        return $chatMember ? $chatMember->status : null;
    }
}
