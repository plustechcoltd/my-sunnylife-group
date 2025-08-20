<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('chat_room_id')->unsigned()->nullable(false)->comment('チャットルームID');
            $table->bigInteger('chat_member_id')->unsigned()->nullable(true)->comment('チャットメンバーID');
            $table->string('message_type')->nullable(false)->comment('タイプ');
            $table->text('message')->nullable(true)->comment('メッセージ');
            $table->json('extra_data')->nullable(true)->comment('追加データ');
            $table->string('display_type')->nullable(false)->comment('');
            $table->timestamp('created_at')->useCurrent()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->comment('更新日時');
            $table->timestamp('deleted_at')->nullable(true)->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
