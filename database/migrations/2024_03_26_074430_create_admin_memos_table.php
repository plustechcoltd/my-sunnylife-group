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
        Schema::create('admin_memos', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->string('record_model')->nullable(false)->comment('対象レコードモデル');
            $table->bigInteger('record_id')->nullable(false)->comment('対象レコードID');
            $table->bigInteger('admin_id')->unsigned()->nullable(false)->index('Fk23id4')->comment('管理ユーザーID');
            $table->foreign('admin_id', 'Fk23id4')->references('id')->on('admins');
            $table->text('description')->nullable(false)->comment('本文');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->timestamp('deleted_at')->nullable(true)->default(null)->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_memos');
    }
};
