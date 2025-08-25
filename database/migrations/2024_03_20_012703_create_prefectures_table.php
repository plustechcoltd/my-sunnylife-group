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
        Schema::create('prefectures', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->unsignedBigInteger('area_id')->nullable(true)->index('Fk15id2')->comment('エリアID');
            $table->foreign('area_id', 'Fk15id2')->references('id')->on('areas')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name')->nullable(false)->comment('都道府県名');
            $table->string('name_kana')->nullable(false)->comment('都道府県名（カナ）');
            $table->string('name_en')->nullable(false)->comment('都道府県名（英語）');
            $table->string('sortno')->nullable(true)->comment('並び順');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefectures');
    }
};
