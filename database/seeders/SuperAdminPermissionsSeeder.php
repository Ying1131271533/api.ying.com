<?php

namespace Database\Seeders;

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
        // 找到超级管理员角色
        $role = Role::where('name', 'super-admin')->find();
        // 为角色添加权限
        $role->givePermissionTo(Permission::all()); // 给超级管理员角色所有权限
    }
}
