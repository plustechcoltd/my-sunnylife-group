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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->string('name', 255)->nullable()->comment('名前');
            $table->string('type', 255)->nullable(false)->comment('タイプ');
            $table->text('private_key');
            $table->text('public_key');
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
        Schema::dropIfExists('chat_rooms');
    }
};
