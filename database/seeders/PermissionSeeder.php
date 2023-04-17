<?php

namespace Database\Seeders;

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
        // 命令删除
        // php artisan cache:forget spatie.permission.cache

        // 添加权限
        $permissions = [
            ['name' => 'auth.logout', 'cn_name' => '退出登录', 'guard_name' => 'api'],
            ['name' => 'auth.refresh', 'cn_name' => '刷新token', 'guard_name' => 'api'],
            ['name' => 'auth.oss-token', 'cn_name' => '阿里云OSSToken', 'guard_name' => 'api'],
            ['name' => 'admin.test', 'cn_name' => '测试', 'guard_name' => 'api'],
            ['name' => 'users.lock', 'cn_name' => '用户启用禁用', 'guard_name' => 'api'],
            ['name' => 'users.index', 'cn_name' => '用户列表', 'guard_name' => 'api'],
            ['name' => 'users.show', 'cn_name' => '用户详情', 'guard_name' => 'api'],
            ['name' => 'categorys.status', 'cn_name' => '分类状态', 'guard_name' => 'api'],
            ['name' => 'categorys.index', 'cn_name' => '分类列表', 'guard_name' => 'api'],
            ['name' => 'categorys.store', 'cn_name' => '分类添加', 'guard_name' => 'api'],
            ['name' => 'categorys.show', 'cn_name' => '分类详情', 'guard_name' => 'api'],
            ['name' => 'categorys.update', 'cn_name' => '分类更新', 'guard_name' => 'api'],
            ['name' => 'goods.on', 'cn_name' => '商品上架', 'guard_name' => 'api'],
            ['name' => 'goods.recommend', 'cn_name' => '商品推荐', 'guard_name' => 'api'],
            ['name' => 'goods.index', 'cn_name' => '商品列表', 'guard_name' => 'api'],
            ['name' => 'goods.store', 'cn_name' => '商品添加', 'guard_name' => 'api'],
            ['name' => 'goods.show', 'cn_name' => '商品详情', 'guard_name' => 'api'],
            ['name' => 'goods.update', 'cn_name' => '商品更新', 'guard_name' => 'api'],
            ['name' => 'comments.index', 'cn_name' => '评论列表', 'guard_name' => 'api'],
            ['name' => 'comments.show', 'cn_name' => '评论详情', 'guard_name' => 'api'],
            ['name' => 'comments.reply', 'cn_name' => '商家回复', 'guard_name' => 'api'],
            ['name' => 'orders.index', 'cn_name' => '订单列表', 'guard_name' => 'api'],
            ['name' => 'orders.show', 'cn_name' => '订单详情', 'guard_name' => 'api'],
            ['name' => 'orders.post', 'cn_name' => '订单发货', 'guard_name' => 'api'],
            ['name' => 'slides.status', 'cn_name' => '轮播图状态', 'guard_name' => 'api'],
            ['name' => 'slides.sort', 'cn_name' => '轮播图添加', 'guard_name' => 'api'],
            ['name' => 'slides.index', 'cn_name' => '轮播图列表', 'guard_name' => 'api'],
            ['name' => 'slides.store', 'cn_name' => '轮播图添加', 'guard_name' => 'api'],
            ['name' => 'slides.show', 'cn_name' => '轮播图详情', 'guard_name' => 'api'],
            ['name' => 'slides.update', 'cn_name' => '轮播图更新', 'guard_name' => 'api'],
            ['name' => 'slides.destroy', 'cn_name' => '轮播图删除', 'guard_name' => 'api'],
            ['name' => 'menus.index', 'cn_name' => '菜单列表', 'guard_name' => 'api'],
        ];
        // 使用扩展自带的模型插入数据
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // 添加角色
        $role = Role::create(['name' => 'super-admin', 'cn_name' => '超级管理员', 'guard_name' => 'api']);

        // 为角色添加权限
        $role->givePermissionTo(Permission::all()); // 给超级管理员所有权限
    }
}
