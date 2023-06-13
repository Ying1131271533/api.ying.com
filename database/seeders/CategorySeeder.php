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
        // 参考京东的分类，不知道名称的就看浏览器页面的title，显示：男士T恤 男装【行情 价格
        // 或者是商品列表上的分类导航：服饰内衣 > 男装 > 男士T恤
        $categorys = [
            [
                'name'      => '家用电器',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'     => '大家电',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '冰箱',
                                'level' => 3,
                            ],
                            [
                                'name'  => '空调',
                                'level' => 3,
                            ],
                            [
                                'name'  => '平板电视',
                                'level' => 3,
                            ],
                        ],
                    ],
                    [
                        'name'     => '厨卫大电',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '油烟机',
                                'level' => 3,
                            ],
                            [
                                'name'  => '洗碗机',
                                'level' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name'      => '手机通讯',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'     => '手机',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '手机',
                                'level' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name'      => '电脑、办公',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'     => '电脑整机',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '笔记本',
                                'level' => 3,
                            ],
                            [
                                'name'  => '游戏本',
                                'level' => 3,
                            ],
                            [
                                'name'  => '台式机',
                                'level' => 3,
                            ],
                        ],
                    ],
                    [
                        'name'     => '电脑配件',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '显示器',
                                'level' => 3,
                            ],
                            [
                                'name'  => 'CPU',
                                'level' => 3,
                            ],
                            [
                                'name'  => '主板',
                                'level' => 3,
                            ],
                            [
                                'name'  => '显卡',
                                'level' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name'      => '服饰内衣',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'     => '男装',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '男士T恤',

                                'level' => 3,
                            ],
                            [
                                'name'  => '衬衫',
                                'level' => 3,
                            ],
                            [
                                'name'  => '工装',

                                'level' => 3,
                            ],
                        ],
                    ],
                    [
                        'name'     => '女装',
                        'level'    => 2,
                        'children' => [
                            [
                                'name'  => '女士T恤',

                                'level' => 3,
                            ],
                            [
                                'name'  => '衬衫',
                                'level' => 3,
                            ],
                            [
                                'name'  => '工装',
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
                $level_2_model->children()->createMany($level_2_children);
            }
        }

        // 清除分类缓存
        forget_cache_category();
    }
}
