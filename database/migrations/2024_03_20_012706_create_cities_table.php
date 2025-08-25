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
        Schema::create('cities', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->bigInteger('prefecture_id')->unsigned()->nullable(true)->index('Fk28id2')->comment('都道府県ID');
            $table->foreign('prefecture_id', 'Fk28id2')->references('id')->on('prefectures')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('name')->nullable(false)->comment('市区町村名');
            $table->string('name_kana')->nullable(false)->comment('市区町村名（カナ）');
            $table->bigInteger('city_group_id')->unsigned()->nullable(true)->comment('市区町村グループID');
            $table->string('search_exclusion_yn')->nullable(true)->comment('検索対象除外フラグ');
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
        Schema::dropIfExists('cities');
    }
};
