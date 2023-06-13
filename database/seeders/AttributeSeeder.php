<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'goods_type_id' => 1,
                'name' => '网络制式',
                'is_index' => 1,
                'input_type' => 0,
            ],
            [
                'goods_type_id' => 1,
                'name' => '尺寸/体积',
                'is_index' => 1,
                'input_type' => 0,
            ],
            [
                'goods_type_id' => 1,
                'name' => '外观样式/手机类型',
                'is_index' => 1,
                'input_type' => 1,
                'values' => [
                    '翻盖',
                    '触屏',
                ],
            ],
            [
                'goods_type_id' => 3,
                'name' => '布料',
                'is_index' => 0,
                'input_type' => 0,
            ],
            [
                'goods_type_id' => 3,
                'name' => '适用季节',
                'is_index' => 1,
                'input_type' => 1,
                'values' => [
                    '春季',
                    '夏季',
                    '秋季',
                    '冬季',
                ],
            ],
        ];

        foreach ($data as $value) {
            Attribute::create($value);
        }

    }
}

