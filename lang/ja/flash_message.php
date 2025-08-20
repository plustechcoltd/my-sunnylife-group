<?php

return [
    'success' => [
        'create' => '#:id :name が作成されました。',
        'update' => '#:id :name が更新されました。',
        'update_no_id' => '更新が成功しました。',
        'delete' => '#:id :name が削除されました。',
        'import' => 'データが正常にインポートされました。',
        'contact_sent' => '連絡が正常に送信されました。'
    ],
    'error' => [
        'import_csv' => 'CSVファイルが無効です。ファイルを確認して再試行してください。',
        'self_delete' => 'ログイン中のユーザーは削除できません。',
    ],
];
