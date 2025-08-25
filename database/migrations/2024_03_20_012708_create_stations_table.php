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
        Schema::create('stations', function (Blueprint $table) {
            $table->bigInteger('station_cd', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('station_g_cd')->unsigned()->nullable(false)->comment('駅_g_cd');
            $table->string('station_name')->nullable(true)->comment('駅名');
            $table->string('station_name_k')->nullable(true)->comment('駅名_k');
            $table->string('station_name_r')->nullable(true)->comment('駅名_r');
            $table->bigInteger('line_cd')->unsigned()->nullable(false)->index('Fk31id6')->comment('鉄道路線cd');
            $table->foreign('line_cd', 'Fk31id6')->references('line_cd')->on('train_lines')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->bigInteger('prefecture_id')->unsigned()->nullable(false)->index('Fk31id7')->comment('都道府県ID');
            $table->foreign('prefecture_id', 'Fk31id7')->references('id')->on('prefectures')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('postal_code')->nullable(false)->comment('郵便番号');
            $table->text('address')->nullable(false)->comment('住所');
            $table->float('lat')->nullable(false)->comment('緯度');
            $table->float('lon')->nullable(false)->comment('経度');
            $table->string('open_ymd')->nullable(false)->comment('開設年月日');
            $table->string('close_ymd')->nullable(false)->comment('閉設年月日');
            $table->integer('e_status')->nullable(false)->comment('eステータス');
            $table->integer('e_sort')->nullable(false)->comment('e並び順');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
