<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('admins')->truncate();
        DB::table('admin_permission_admin')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $adminPermissionIds = AdminPermission::all()->pluck('id')->toArray();

        $admin = new Admin();
        $admin->id = 1;
        $admin->family_name = '管理';
        $admin->first_name = '太郎';
        $admin->email = 'admin@starter.local';
        $admin->password = bcrypt('secret'); // pls update this password when released
        $admin->phone = '0312341234';
        $admin->save();
        $admin->permissions()->sync($adminPermissionIds);

        // 50 dummy data
        Admin::factory()->count(50)->create();
    }
}
