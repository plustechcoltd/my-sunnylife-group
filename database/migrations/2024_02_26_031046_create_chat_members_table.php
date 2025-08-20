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
        Schema::create('chat_members', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('chat_room_id')->unsigned()->nullable(false)->comment('チャットルームID');
            $table->string('user_table', 255)->nullable(false)->comment('ユーザータイプ');
            $table->bigInteger('user_id')->unsigned()->nullable(false)->comment('ユーザーID');
            $table->string('status', 255)->nullable()->comment('');
            $table->integer('unread_count')->unsigned()->default(0)->nullable()->comment('');
            $table->bigInteger('last_read_chat_message_id')->unsigned()->nullable(true)->comment('');
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
        Schema::dropIfExists('chat_members');
    }
};
