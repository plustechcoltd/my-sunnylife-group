<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_message_id')->unsigned()->nullable(false)->comment('');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_path');
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
        Schema::dropIfExists('chat_files');
    }
};
