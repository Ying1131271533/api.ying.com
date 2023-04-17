<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
        $user = User::create([
            'name' => '超级管理员',
            'email' => 'akaliying@foxmail.com',
            'password' => bcrypt('123456'),
        ]);
        // 获取用户
        // $user = User::find(1);

        // 给用户分配角色
        $user->assignRole('super-admin');
        // $user->assignRole(['article-admin', 'goods-admin']);
    }
}
