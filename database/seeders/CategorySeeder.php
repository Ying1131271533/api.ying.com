<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 填充分类信息
        $categorys = [
            [
                'name'      => '电子数码',
                'group'     => 'goods',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'     => '手机',
                        'group'    => 'goods',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '华为',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name'  => '小米',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name'  => '苹果',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ],
                    ],
                    [
                        'name'     => '电脑',
                        'group'    => 'goods',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '联想',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name'  => '戴尔',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name'      => '衣帽服装',
                'group'     => 'goods',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'     => '男装',
                        'group'    => 'goods',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '海澜之家',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name'  => 'Nike',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name'  => '优衣库',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ],
                    ],
                    [
                        'name'     => '女装',
                        'group'    => 'goods',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '欧时力',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                            [
                                'name'  => 'Only',
                                'group' => 'goods',
                                'level' => 3,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // 插入数据库
        foreach ($categorys as $level_1) {
            $level_1_children = $level_1['children'];
            unset($level_1['children']);
            $level_1_model = Category::create($level_1);
            foreach ($level_1_children as $level_2) {
                $level_2_children = $level_2['children'];
                unset($level_2['children']);
                // $level_2['parent_id'] = $level_1_model->id;
                // $level_2_model = Category::create($level_2);
                $level_2_model = $level_1_model->children()->create($level_2);
                // $level_2_model->children()->createMany($level_2_children);
            }
        }

        // 清除分类缓存
        forget_cache_category();
    }
}
