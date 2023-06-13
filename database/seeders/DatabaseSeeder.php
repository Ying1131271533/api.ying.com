<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 调用其它的数据填充
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GoodsTypeSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(GoodsSpecSeeder::class);
        // $this->call(CitieSeeder::class); // 中国地区表
    }
}
