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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->string('record_table')->nullable(false)->comment('対象レコードモデル');
            $table->bigInteger('record_id')->unsigned()->nullable(false)->comment('対象レコードID');
            $table->string('action')->nullable(false)->comment('メソッド');
            $table->string('ip_address')->nullable(false)->comment('IPアドレス');
            $table->string('user_agent')->nullable(false)->comment('ユーザーエージェント');
            $table->string('user_table')->nullable(false)->comment('ユーザーモデル');
            $table->bigInteger('user_id')->unsigned()->nullable(true)->comment('ユーザーID');
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
        Schema::dropIfExists('activity_logs');
    }
};
