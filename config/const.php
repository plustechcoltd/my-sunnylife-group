<?php

return [
    'header_background_color_default' => '#252b36',
    'navbar_background_color_default' => '#ffffff',
    
    'user_types' => [
        'admin' => 'admin',
        'user' => 'user',
    ],
    // 性別
    'gender_types' => [
        '1', // 男性
        '2', // 女性
        '3', // どちらでもない
    ],
    // 性別
    'gender_type_values' => [
        'male' => '1',
        'female' => '2',
        'neither' => '3',
    ],
    // 配偶者
    'marital_yn' => [
        'y', // 有
        'n', // 無
    ],
    // 言語ラベル
    'language_labels' => [
        'Japanese',
        'English',
    ],
    // 言語コード
    'language_codes' => [
        'en',
        'ja',
    ],
    // 言語アイコン
    'language_icons' => [
        'ja' => 'assets/admin/images/lang/ja.svg',
        'en' => 'assets/admin/images/lang/gb.svg',
    ],
    // 許可
    'permissions' => [
        'admin:admins',
        'admin:users',
        'admin:activity_logs',
        'admin:institutions',
        'admin:rooms',
        'admin:plans',
        'admin:campaign_plans',
        'admin:trial_plans',
        'admin:nurse_types',
        'admin:room_types',
        'admin:nursing_levels',
        'admin:management_companies',
        'admin:treatments',
        'admin:medical_agencies',
        'admin:medical_services',
        'admin:day_services',
        'admin:files',
        'admin:banners',
        'admin:faqs',
        'admin:faq_categories',
        'admin:managers',
        'admin:settings',
        'admin:languages',
    ],
    
    'chat_member_roles' => [
        'admin' => 'admin',
        'user' => 'user',
    ],
    'chat_room_prefix' => 'chats.',
    'chat_room_types' => [
        'support' => 'support',
    ],
    'chat_message_types' => [
        'text' => 'text',
    ],
    'chat_room_events' => [
        'created' => 'chat_room.created',
        'message' => 'chat_room.message',
        'seen_all' => 'chat_room.seen_all',
    ],
    'default_avatar' => [
        'admin' => '/images/default_avatar.jpg',
        'user' => '/images/default_avatar.jpg',
    ],

    // Date format
    'date_format' => 'm/d/Y H:i:s',

    // Logging format key for admin and user actions in the system logs
    'logging' => [
        'admin' => 'admin',
        'user' => 'user',
    ],

    // Models used in the system
    'models' => [
        'admins' => 'App\Models\Admin',
        'users' => 'App\Models\User',
        'settings' => 'App\Models\Setting',
        'activity_logs' => 'App\Models\ActivityLog',
        'institutions' => 'App\Models\Institution',
        'notifications' => 'App\Models\Notification',
    ],

    // Icons for models used in the system
    'icons' => [
        'admins' => 'ph-user-gear',
        'users' => 'ph-users',
        'settings' => 'ph-gear',
        'languages' => 'ph-translate',
        'activity_logs' => 'ph-scroll',
        'institutions' => 'ph-building',
        'notifications' => 'ph-bell',
    ],

    // Auth tables
    'auth_tables' => [
        'admin' => 'admins',
        'user' => 'users',
    ],
];
