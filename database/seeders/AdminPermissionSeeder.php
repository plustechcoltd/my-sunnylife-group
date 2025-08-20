<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('admin_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach (config('const.permissions') as $permission) {
            DB::table('admin_permissions')->insert([
                'name' => $permission,
            ]);
        }
    }
}
