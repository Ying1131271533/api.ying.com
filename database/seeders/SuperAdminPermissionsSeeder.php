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
        app()['cache']->forget('spatie.permission.cache');

        // 获取超级管理员目前拥有的权限
        $admin = Admin::where('email', 'akaliying@foxmail.com')->first();
        $permissions = $admin->getAllPermissions();

        // 找到超级管理员角色
        $role = Role::where('name', 'super-admin')->first();

        // 删除权限
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
            $permission->removeRole($role);
        }

        // 给超级管理员角色所有权限
        $role->givePermissionTo(Permission::all());

    }
}
