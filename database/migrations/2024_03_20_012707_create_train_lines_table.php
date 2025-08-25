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
        Schema::create('train_lines', function (Blueprint $table) {
            $table->bigInteger('line_cd', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('company_cd')->unsigned()->nullable(false)->comment('鉄道');
            $table->string('line_name')->nullable(false)->comment('路線名');
            $table->string('line_name_k')->nullable(false)->comment('路線名_k');
            $table->string('line_name_h')->nullable(false)->comment('路線名_h');
            $table->string('line_color_c')->nullable(true)->comment('路線カラー_c');
            $table->string('line_color_t')->nullable(true)->comment('路線カラー_t');
            $table->string('line_type')->nullable(true)->comment('路線タイプ');
            $table->float('lat')->nullable(false)->comment('緯度');
            $table->float('lon')->nullable(false)->comment('経度');
            $table->integer('zoom')->nullable(false)->comment('ズーム値');
            $table->integer('e_status')->nullable(true)->comment('eステータス');
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
        Schema::dropIfExists('train_lines');
    }
};
