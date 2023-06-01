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
                    [
                        'name' => 'auth.list', 'cn_name' => '授权操作', 'guard_name' => 'admin', 'level' => 2, 'show' => 0,
                        'children' => [
                            ['name' => 'auth.logout', 'cn_name' => '退出登录', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'auth.refresh', 'cn_name' => '刷新token', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'auth.oss-token', 'cn_name' => '阿里云OSSToken', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'admin.test', 'cn_name' => '测试', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'auth.test', 'cn_name' => '上传文件', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                ],
            ],

            [
                'name' => 'admins', 'cn_name' => '管理员管理', 'guard_name' => 'admin',
                'level' => 1, 'show' => 1,
                'children' => [
                    [
                        'name' => 'admins.index', 'cn_name' => '管理员列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'admins.lock', 'cn_name' => '管理员启用禁用', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'admins.show', 'cn_name' => '管理员详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'admins.store', 'cn_name' => '管理员添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'admins.update', 'cn_name' => '管理员更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'admins.destroy', 'cn_name' => '管理员删除', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'admins.getAdminById', 'cn_name' => '根据id获取管理员信息', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                    [
                        'name' => 'roles.index', 'cn_name' => '角色列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'roles.show', 'cn_name' => '角色详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'roles.store', 'cn_name' => '角色添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'roles.update', 'cn_name' => '角色更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'roles.destroy', 'cn_name' => '角色删除', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                    [
                        'name' => 'permissions.index', 'cn_name' => '权限节点列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'permissions.show', 'cn_name' => '权限节点详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],
                ]
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
                        'name' => 'categorys.index', 'cn_name' => '分类列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'categorys.status', 'cn_name' => '分类状态', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.sort', 'cn_name' => '分类排序', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.store', 'cn_name' => '分类添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.show', 'cn_name' => '分类详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'categorys.update', 'cn_name' => '分类更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                        ]
                    ],

                    [
                        'name' => 'brands.index', 'cn_name' => '品牌列表', 'guard_name' => 'admin', 'level' => 2, 'show' => 1,
                        'children' => [
                            ['name' => 'brands.status', 'cn_name' => '品牌状态', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'brands.sort', 'cn_name' => '品牌排序', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'brands.store', 'cn_name' => '品牌添加', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'brands.show', 'cn_name' => '品牌详情', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
                            ['name' => 'brands.update', 'cn_name' => '品牌更新', 'guard_name' => 'admin', 'level' => 3, 'show' => 0],
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

        // 使用扩展自带的模型插入数据 只能二维数组
        // foreach ($permissions as $permission) {
        //     Permission::create($permission);
        // }

        foreach ($permissions as $level_1) {
            $level_1_children = $level_1['children'];
            unset($level_1['children']);
            $level_1_model = Node::create($level_1);
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
