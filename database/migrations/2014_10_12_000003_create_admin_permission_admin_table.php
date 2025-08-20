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
        Schema::create('admin_permission_admin', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('admin_id')->unsigned()->nullable(false)->comment('施設ユーザーID');
            $table->foreign('admin_id')->references('id')->on('admins')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->bigInteger('admin_permission_id')->unsigned()->nullable(false)->comment('施設ユーザー許可ID');
            $table->foreign('admin_permission_id')->references('id')->on('admin_permissions')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('admin_permission_admin');
    }
};
