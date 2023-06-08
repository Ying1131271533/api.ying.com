<?php

namespace Database\Seeders;

use App\Models\Spec;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoodsSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specs = [
            [
                'goods_type_id' => 1,
                'name' => '机身颜色',
                'is_index' => 0,
                'items' => [
                    '蓝色',
                    '紫色',
                    '黄色',
                    '红色',
                    '午夜色',
                    '星光色',
                ],
            ],
            [
                'goods_type_id' => 1,
                'name' => '存储容量',
                'is_index' => 1,
                'items' => [
                    '128G',
                    '256G',
                    '512G',
                ],
            ],
            [
                'goods_type_id' => 1,
                'name' => '网络',
                'is_index' => 0,
                'items' => [
                    '4G',
                    '5G',
                ],
            ],
            [
                'goods_type_id' => 3,
                'name' => '颜色',
                'is_index' => 0,
                'items' => [
                    '红色',
                    '蓝色',
                ],
            ],
            [
                'goods_type_id' => 3,
                'name' => '尺码',
                'is_index' => 1,
                'items' => [
                    'XXS',
                    'XS',
                    'S',
                    'M',
                    'L',
                    'XL',
                    '均码',
                ],
            ],
        ];

        foreach ($specs as $spec) {

            // 获取规格项
            $spec_items = $spec['items'];
            unset($spec['items']);
            $spec = Spec::create($spec);

            // 保存规格项
            $items = [];
            foreach ($spec_items as $spec_item) {
                $items[] = ['name' => $spec_item];
            }
            $result = $spec->items()->createMany($items);
        }
    }
}
