<?php

namespace Database\Seeders;

use App\Models\Good;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成大量测试用的商品数据
        Good::factory()->count(500)->create();
    }
}
