<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->string('code')->nullable(true)->unique('code')->comment('社員コード');
            $table->string('family_name')->nullable(false)->comment('苗字');
            $table->string('first_name')->nullable(true)->comment('名前');
            $table->string('gender')->nullable(true)->comment('性別');
            $table->string('email')->nullable(false)->unique('email')->comment('メールアドレス');
            $table->string('phone')->nullable(true)->comment('電話番号');
            $table->string('password')->nullable(false)->comment('パスワード');
            $table->string('avatar_image_path')->nullable(true)->comment('アバター画像URL');
            $table->string('remember_token')->nullable(true)->comment('再発行用トークン');
            $table->timestamp('email_verified_at')->nullable(true)->comment('メールアドレス確認日時');
            $table->timestamp('last_login_at')->nullable(true)->comment('最終ログイン日時');
            $table->json('allowed_ips')->nullable(true)->comment('許可IPアドレス');
            $table->string('language')->nullable(true)->comment('ユーザーの言語を設定する');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->timestamp('deleted_at')->nullable(true)->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
