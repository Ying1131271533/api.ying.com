<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清除 缓存
        forget_permission_cache();

        // 找到超级管理员角色
        $role = Role::where('name', 'super-admin')->first();

        // 一次性撤销和添加新权限
        $role->syncPermissions(Permission::all());
    }
}
