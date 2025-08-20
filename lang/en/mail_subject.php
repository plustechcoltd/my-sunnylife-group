<?php
return [
    'web' => [
        'password' => [
            'reset_to_user' => 'Reset Password Notification',
        ],
        'contact' => [
            'store_to_user' => 'Test contact form [:contact.id]'
        ],
        'register' => [
            'register_to_admin' => "【サービス名】仮会員登録完了のお知らせ。ユーザー [:user.id]"
        ]
    ],

    'admin' => [
        'password' => [
            'reset_to_admin' => 'Reset Password Notification'
        ]
    ],
];
