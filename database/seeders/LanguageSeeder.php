<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('languages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::table('languages')->insertOrIgnore([
            'code' => 'ja',
            'flag' => 'jp',
            'label' => '日本語',
            'default_yn' => 'y',
            'sortno' => 0,
        ]);

        DB::table('languages')->insertOrIgnore([
            'code' => 'en',
            'flag' => 'us',
            'label' => 'English',
            'default_yn' => null,
            'sortno' => 1,
        ]);

        DB::table('languages')->insertOrIgnore([
            'code' => 'vi',
            'flag' => 'vn',
            'label' => 'Tiếng Việt',
            'default_yn' => null,
            'sortno' => 2,
        ]);
    }
}
