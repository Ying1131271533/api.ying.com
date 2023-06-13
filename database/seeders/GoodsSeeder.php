<?php

namespace Database\Seeders;

use App\Models\Goods;
use App\Models\GoodsDetails;
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
        // 生成商品数据
        Goods::factory()
        // ->has(GoodsDetails::factory()->count(1), 'details')
        ->hasDetails(1)
        ->count(100)
        ->create();
    }
}
