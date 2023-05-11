<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 填充菜单数据
        $menus = [
            [
                'name'      => '用户管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '用户列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
            [
                'name'      => '分类管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '添加分类',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name'  => '分类列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
            [
                'name'      => '商品管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '添加商品',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name'  => '商品列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
            [
                'name'      => '评价管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '评价列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
            [
                'name'      => '订单管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '订单列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
            [
                'name'      => '轮播图管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '添加轮播图',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name'  => '轮播图列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
            [
                'name'      => '菜单管理',
                'group'     => 'menu',
                'parent_id' => 0,
                'level'     => 1,
                'children'  => [
                    [
                        'name'  => '添加菜单',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name'  => '菜单列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ],
            ],
        ];

        // 循环菜单数据，插入数据库
        foreach ($menus as $menu) {
            $children = $menu['children'];
            unset($menu['children']);
            $one_menu = Category::create($menu);
            $one_menu->children()->createMany($children);
        }
        // 清除缓存
        forget_cache_category();
    }
}
