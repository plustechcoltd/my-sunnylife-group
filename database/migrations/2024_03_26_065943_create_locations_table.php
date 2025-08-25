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
        Schema::create('locations', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->nullable(false)->comment('ID');
            $table->string('code')->nullable(false)->unique('code')->comment('管理コード');
            $table->bigInteger('contract_id')->unsigned()->nullable(true)->index('Fk17id3')->comment('契約状況ID');
//            $table->foreign('contract_id', 'Fk17id3')->references('id')->on('contracts');
            $table->unsignedBigInteger('location_group_id')->unsigned()->nullable(true)->index('Fk17id4')->comment('医療グループID');
            $table->foreign('location_group_id', 'Fk17id4')->references('id')->on('location_groups');
            $table->string('name')->nullable(false)->comment('医療機関名');
            $table->string('name_kana')->nullable(true)->comment('医療機関名(カナ)');
            $table->text('medical_department')->nullable(true)->comment('診療科目');
            $table->string('postal_code')->nullable(true)->comment('郵便番号');
            $table->bigInteger('prefecture_id')->unsigned()->nullable(false)->index('Fk17id9')->comment('都道府県');
            $table->foreign('prefecture_id', 'Fk17id9')->references('id')->on('prefectures');
            $table->bigInteger('city_id')->unsigned()->nullable(false)->index('Fk17id10')->comment('市区町村');
            $table->foreign('city_id', 'Fk17id10')->references('id')->on('cities');
            $table->string('address1')->nullable(true)->comment('番地以下');
            $table->string('address2')->nullable(true)->comment('マンション名');
            $table->string('tel')->nullable(true)->comment('電話番号（施設）');
            $table->string('url')->nullable(true)->comment('ホームページURL');
            $table->string('emergency_support_yn')->nullable(true)->comment('救急対応');
            $table->string('number_of_beds')->nullable(true)->comment('病床数');
            $table->string('number_of_beds_type')->nullable(true)->comment('病床数区分');
            $table->integer('number_of_dialysis_beds')->nullable(true)->comment('透析ベッド数');
            $table->date('open_date')->nullable(true)->comment('開設日');
            $table->string('founder_name')->nullable(true)->comment('理事長名');
            $table->string('manager_name')->nullable(true)->comment('院長名');
            $table->geometry('location')->nullable(true)->comment('ロケーション');
            $table->float('lat')->nullable(true)->comment('緯度');
            $table->float('lon')->nullable(true)->comment('経度');
            $table->string('contact_family_name')->nullable(true)->comment('お問合せ先担当者　姓');
            $table->string('contact_first_name')->nullable(true)->comment('お問合せ先担当者　名');
            $table->string('contact_family_name_kana')->nullable(true)->comment('お問合せ先担当者　姓（セイ）');
            $table->string('contact_first_name_kana')->nullable(true)->comment('お問合せ先担当者　名（メイ）');
            $table->string('contact_department')->nullable(true)->comment('お問合せ先担当者　部署');
            $table->string('contact_position')->nullable(true)->comment('お問合せ先担当者　役職');
            $table->string('contact_phone')->nullable(true)->comment('お問合せ先担当者　電話番号');
            $table->string('contact_email')->nullable(true)->comment('お問合せ先担当者　メールアドレス');
            $table->string('reference_code')->nullable(true)->comment('参照コード');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->softDeletes()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
