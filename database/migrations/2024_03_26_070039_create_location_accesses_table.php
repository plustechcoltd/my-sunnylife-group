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
        Schema::create('location_accesses', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('location_id')->unsigned()->nullable(false)->index('Fk18id2')->comment('医療機関ID');
            $table->foreign('location_id', 'Fk18id2')->references('id')->on('locations');
            $table->bigInteger('station_g_cd')->nullable(false)->comment('駅_g_cd');
            $table->string('transportation_type')->nullable(true)->comment('移動手段');
            $table->integer('total_time')->nullable(true)->comment('交通時間(分)');
            $table->string('access_text')->nullable(true)->comment('交通補足');
            $table->integer('sortno')->nullable(true)->comment('並び順');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_accesses');
    }
};
