<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清除缓存
        app()['cache']->forget('spatie.role.cache');

        // 创建用户
        $admin = Admin::create([
            'name' => '超级管理员',
            'email' => 'akaliying@foxmail.com',
            'password' => bcrypt('123456'),
        ]);

        // 给用户分配角色
        $admin->assignRole('super-admin');
        // $admin->assignRole(['article-admin', 'goods-admin']);
    }
}
