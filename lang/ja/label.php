<?php

return [
    // buttons
    'buttons' => [
        'create' => '新規作成',
        'edit' => '変更する',
        'save' => '変更する',
        'delete' => '削除',
        'export_csv' => 'CSVをエクスポート',
        'import_csv' => 'CSVをインポート',
        'login' => 'ログイン',
        'logout' => 'ログアウト',
        'submit' => '提出する',
    ],

    // menus
    'menus' => [
        'home' => 'ホーム',
        'activity_logs' => 'アクティビティログ',
        'users' => 'ユーザー',
        'create_user' => 'ユーザーを作成',
        'admins' => '管理者',
        'create_admin' => '管理者を作成',
        'my_profile' => 'マイプロフィール',
        'settings' => '設定',
        'languages' => '言語',
        'contacts' => '接触',
        'pages' => 'ページ',
    ],

    // models
    'tables' => [
        'admins' => '管理者',
        'users' => 'ユーザー',
        'settings' => '設定',
        'languages' => '言語',
        'contacts' => '接触',
        'activity_logs' => 'アクティビティログ',
        'institutions' => '機関',
        'notifications' => '通知',
    ],

    'columns' => [
        'common' => [
            'id' => 'ID',
            'created_at' => '作成日時',
            'updated_at' => '更新日時',
            'deleted_at' => '削除日時',
            'actions' => 'アクション',
        ],

        // admins
        'admins' => [
            'code' => 'コード',
            'email' => 'メールアドレス',
            'phone' => '電話番号',
            'family_name' => '姓',
            'first_name' => '名',
            'full_name' => 'フルネーム',
            'gender' => '性別',
            'avatar_image_path' => 'プロフィール画像',
            'language' => '言語',
            'password' => 'パスワード',
            'current_password' => '現在のパスワード',
            'admin_permissions' => '管理者の権限',
            'allowed_ips' => '許可IPアドレス',
        ],

        // users
        'users' => [
            'code' => 'コード',
            'first_name' => '名',
            'family_name' => '姓',
            'email' => 'メールアドレス',
            'gender' => '性別',
            'avatar_image_path' => 'プロフィール画像',
            'phone' => '電話番号',
            'language' => '言語',
            'password' => 'パスワード',
            'allowed_ips' => '許可IPアドレス',
        ],

        // settings
        'settings' => [
            'site_settings' => 'サイト設定',
            'site_title' => 'サイトタイトル',
            'site_description' => 'サイトの説明',
            'maintenance_message' => 'メンテナンスメッセージ',
            'logo_login' => 'ログインページのロゴ',
            'logo' => 'サイトのロゴ',
            'light_logo' => 'サイトのライトロゴ',
            'favicon' => 'サイトのファビコン',
            'boxed_page' => 'ボックスレイアウトページ',
            'fixed_footer' => '固定フッター',
            'display_footer' => 'フッターを表示',
            'header_background_color' => 'ヘッダー背景色',
            'header_text_color' => 'ヘッダー文字色',
            'navbar_background_color' => 'ナビバー背景色',
            'navbar_text_color' => 'ナビバー文字色',
        ],

        'languages' => [
            'code' => 'コード',
            'flag' => 'フラグ',
            'label' => 'ラベル',
            'default_yn' => 'デフォルト',
            'sortno' => '表示順序',
        ],

        'contacts' => [
            'email' => 'メールアドレス',
            'title' => 'タイトル',
            'content' => 'コンテンツ'
        ],

        // activity_logs
        'activity_logs' => [
            'user' => 'ユーザー',
            'action' => 'アクション',
            'record' => 'レコード',
            'description' => '説明',
            'ip_address' => 'IPアドレス',
            'user_agent' => 'ユーザーエージェント',
        ],
    ],

    // Labels
    'labels' => [
        'list' => 'リスト',
        'create' => '作成',
        'edit' => '編集',
        'import' => 'インポート',
        'deleted' => '(削除済み)',
        'basic_info' => '基本情報',
        'password_setting' => 'パスワード設定',
        'permission_setting' => '権限設定',
        'general_setting' => '一般設定',
        'language' => '言語',
        'contact' => '接触',
        'upload_csv_file' => 'CSVファイルをアップロード',
        'my_profile' => 'マイプロフィール',
        'edit_profile' => 'プロフィールを編集',
        'edit_manager' => 'Edit Manager',
        'list_room' => 'メッセージー覧',
        'search_user_name' => 'ユーザー名を検索...',
        'new_message' => '新着メッセージ',
        'view_all' => 'すべてのメッセージを見る',
        'badge_no_message' => '新着メッセージを受信したときここに表示されます。',
        'seen' => '既読',
        'is_typing' => 'が入力しています',
        'leave_chat' => 'チャットルームから退出',

        // pages title
        'dashboard' => 'ダッシュボード',
        'login' => 'ログイン',
        'forget_password' => 'パスワードを忘れた',
        'reset_password' => 'パスワードをリセット',
        'profile' => 'プロフィール',
        'change_permissions' => '権限を変更',
        'change_password' => 'パスワードを変更',
        'edit_admin' => ':name | 管理者',
        'change_permissions_admin' => '権限を変更 | 管理者',
        'change_password_admin' => 'パスワードを変更 | 管理者',
        'chats' => 'チャット',
        'start_chat' => 'チャットを開始',
        'edit_user' => ':name | ユーザー',
        'change_password_user' => 'パスワードを変更 | ユーザー',
        'add_language' => '言語を追加',
        'no_language_available' => '利用可能な言語はありません',
        'manager_user' => 'Manager | User',
    ],
];
