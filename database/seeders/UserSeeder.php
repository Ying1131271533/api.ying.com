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

        // 创建用户
        $user = User::create([
            'name' => 'akali',
            'email' => '1131271533@qq.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
