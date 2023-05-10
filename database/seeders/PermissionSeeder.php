<?php

namespace Database\Seeders;

use App\Models\Node;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');
        // php 命令删除
        // php artisan cache:forget spatie.permission.cache

        // 添加权限
        $permissions = [
            [
                'name' => 'auth', 'cn_name' => '授权管理', 'guard_name' => 'admin',
                'level' => 1, 'show' => 0,
                'children'   => [
                    ['name' => 'auth.logout', 'cn_name' => '退出登录', 'guard_name' => 'admin', 'level' => 2, 'show' => 0],
                    ['name' => 'auth.refresh', 'cn_name' => '刷新token', 'guard_name' => 'admin', 'level' => 2, 'show' => 0],
                    ['name' => 'auth.oss-token', 'cn_name' => '阿里云OSSToken', 'guard_name' => 'admin', 'level' => 2, 'show' => 0],
                    ['name' => 'admin.test', 'cn_name' => '测试', 'guard_name' => 'admin', 'level' => 2, 'show' => 0],
                ],
            ],

            [
                'name' => 'users', 'cn_name' => '用户管理', 'guard_name' => 'admin',
                'level' => 1, 'show' => 1,
                'children' => [
                    [
                        'name' => 'users.index', 'cn_name' => '用户列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'users.lock', 'cn_name' => '用户启用禁用', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'users.show', 'cn_name' => '用户详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                ]
            ],

            [
                'name' => 'goods', 'cn_name' => '商品管理', 'guard_name' => 'admin',
                'level' => 1, 'show' => 1,
                'children' => [
                    [
                        'name' => 'categorys.index', 'cn_name' => '商品分类', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'categorys.status', 'cn_name' => '分类状态', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.store', 'cn_name' => '分类添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.show', 'cn_name' => '分类详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.update', 'cn_name' => '分类更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],

                    [
                        'name' => 'goods.index', 'cn_name' => '商品管理', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'goods.on', 'cn_name' => '商品上架', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'goods.recommend', 'cn_name' => '商品推荐', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'goods.store', 'cn_name' => '商品添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'goods.show', 'cn_name' => '商品详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'goods.update', 'cn_name' => '商品更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],

                    [
                        'name' => 'comments.index', 'cn_name' => '评价列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'comments.show', 'cn_name' => '评价详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'comments.reply', 'cn_name' => '商家回复', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                ]
            ],

            [
                'name' => 'orders', 'cn_name' => '订单管理', 'guard_name' => 'admin',
                'level' => 1, 'show' => 1,
                'children' => [
                    [
                        'name' => 'orders.index', 'cn_name' => '订单列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'orders.show', 'cn_name' => '订单详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'orders.post', 'cn_name' => '订单发货', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                ]
            ],

            [
                'name' => 'slides', 'cn_name' => '轮播图管理', 'guard_name' => 'admin',
                'level' => 1, 'show' => 1,
                'children' => [
                    [
                        'name' => 'slides.index', 'cn_name' => '轮播图列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'slides.status', 'cn_name' => '轮播图状态', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'slides.sort', 'cn_name' => '轮播图添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'slides.store', 'cn_name' => '轮播图添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'slides.show', 'cn_name' => '轮播图详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'slides.update', 'cn_name' => '轮播图更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'slides.destroy', 'cn_name' => '轮播图删除', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                ]
            ],
        ];

        // 使用扩展自带的模型插入数据
        // foreach ($permissions as $permission) {
        //     $level_1_children = $permission['children'];
        //     unset($permission['children']);
        //     $level_1_model = Permission::create($permission);
        //     foreach ($level_1_children as $level_2) {
        //         $level_2_children = $level_2['children'];
        //         unset($level_2['children']);
        //         $level_2['parent_id'] = $level_1_model->id;
        //         $level_2_model = Permission::create($level_2);
        //         foreach ($level_2_children as $level_3) {
        //             $level_3['parent_id'] = $level_2_model->id;
        //             $level_3_model = Permission::create($level_3);
        //         }
        //     }
        // }

        foreach ($permissions as $permission) {
            $level_1_children = $permission['children'];
            unset($permission['children']);
            $level_1_model = Node::create($permission);
            foreach ($level_1_children as $level_2) {
                $level_2_children = $level_2['children'];
                unset($level_2['children']);
                $level_2_model = $level_1_model->children()->create($level_2);
                $level_2_model->children()->createMany($level_2_children);
            }
        }

        // 添加角色
        $role = Role::create(['name' => 'super-admin', 'cn_name' => '超级管理员', 'guard_name' => 'admin']);

        // 为角色添加权限
        $role->givePermissionTo(Permission::all()); // 给超级管理员角色所有权限
    }
}
