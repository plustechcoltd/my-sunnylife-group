<?php

return [
    'actions' => [
        'store' => '新規作成',
        'update' => '変更する',
        'destroy' => '削除',
        'import' => 'インポート',
        'export' => 'エクスポート',
        'update_password' => 'パスワードを変更する',
        'update_permissions' => '権限を変更する',
        'login' => 'ログイン',
        'register' => '登録',
        'update_profile' => 'プロフィールを変更する',
        'update_profile_permissions' => 'プロフィール権限を変更する',
        'update_profile_password' => 'プロフィールパスワードを変更する',
    ],
    'descriptions' => [
        'store' => ':user_table:user_nameが新しい:record_table:record_nameを追加しました',
        'update' => ':user_table:user_nameが:record_table:record_nameの基本情報を追加しました',
        'destroy' => ':user_table:user_nameが:record_tableID::record_idを削除しました',
        'import' => ':user_table:user_nameが:record_tableを一括インポートいたしました',
        'export' => ':user_table:user_nameが:record_tableのデータをエクスポートしました',
        'update_password' => ':user_table:user_nameが:record_nameのパスワードを変更しました',
        'update_permissions' => ':user_table:user_nameが:record_nameの許可を変更しました',
        'login' => ':user_table:user_nameがログインしました',
        'register' => ':user_table:user_nameが新規登録しました',
        'update_profile' => ':user_table:user_nameがプロフィールの基本情報を変更しました',
        'update_profile_permissions' => ':user_table:user_nameがプロフィールの許可を変更しました',
        'update_profile_password' => ':user_table:user_nameがプロフィールのパスワードを変更しました',
    ]
];
