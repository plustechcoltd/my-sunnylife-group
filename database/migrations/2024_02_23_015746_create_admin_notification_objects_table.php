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
        Schema::create('admin_notification_objects', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->string('admin_notification_id')->nullable(false);
            $table->string('record_model')->nullable(false);
            $table->bigInteger('record_id')->nullable(false);
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
        Schema::dropIfExists('admin_notification_objects');
    }
};
