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

    // 施設種別（施設形態）
    'location_types' => [
        '1' => '一般',
        '2' => '療養型',
        '3' => 'リハビリ',
        '4' => '精神',
        '5' => 'クリニック',
        '6' => '老健',
        '7' => '企業',
        '8' => 'その他',
    ],

    // 救急対応
    'emergency_support_yn' => [
        'y' => 'あり',
        'n' => 'なし',
    ],

    // 病棟数区分
    'number_of_beds_types' => [
        '1' => '0床',
        '2' => '1～19床',
        '3' => '20～99床',
        '4' => '100～199床',
        '5' => '200～299床',
        '6' => '300床以上',
        '7' => '老健1～99',
        '8' => '老健100～199',
    ],

    // 移動手段
    'transportation_types' => [
        '1' => '徒歩',
        '2' => '車',
        '3' => 'タクシー',
        '4' => 'バス',
        '5' => '専用バス',
    ],
];
