<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 添加权限
        $permissions = [
            // guard_name(看守器名称)，就是 config/auth.guards 默认使用web
            // User模型那边增加 protected $guard_name = 'api'; 这里的guard_name就可以不写
            // ['name' => '', 'cn_name' => '', 'guard_name' => 'api'],
            ['name' => 'auth.logout', 'cn_name' => '退出登录'],
            ['name' => 'auth.refresh', 'cn_name' => '刷新token'],
            ['name' => 'auth.oss-token', 'cn_name' => '阿里云OSSToken'],
            ['name' => 'admin.test', 'cn_name' => '测试'],
            ['name' => 'users.lock', 'cn_name' => '用户启用禁用'],
            ['name' => 'users.index', 'cn_name' => '用户列表'],
            ['name' => 'users.show', 'cn_name' => '用户详情'],
            ['name' => 'categorys.status', 'cn_name' => '分类状态'],
            ['name' => 'categorys.index', 'cn_name' => '分类列表'],
            ['name' => 'categorys.store', 'cn_name' => '分类添加'],
            ['name' => 'categorys.show', 'cn_name' => '分类详情'],
            ['name' => 'categorys.update', 'cn_name' => '分类更新'],
            ['name' => 'goods.on', 'cn_name' => '商品上架'],
            ['name' => 'goods.recommend', 'cn_name' => '商品推荐'],
            ['name' => 'goods.index', 'cn_name' => '商品列表'],
            ['name' => 'goods.store', 'cn_name' => '商品添加'],
            ['name' => 'goods.show', 'cn_name' => '商品详情'],
            ['name' => 'goods.update', 'cn_name' => '商品更新'],
            ['name' => 'comments.index', 'cn_name' => '评论列表'],
            ['name' => 'comments.show', 'cn_name' => '评论详情'],
            ['name' => 'comments.reply', 'cn_name' => '商家回复'],
            ['name' => 'orders.index', 'cn_name' => '订单列表'],
            ['name' => 'orders.show', 'cn_name' => '订单详情'],
            ['name' => 'orders.post', 'cn_name' => '订单发货'],
            ['name' => 'slides.status', 'cn_name' => '轮播图状态'],
            ['name' => 'slides.sort', 'cn_name' => '轮播图添加'],
            ['name' => 'slides.index', 'cn_name' => '轮播图列表'],
            ['name' => 'slides.store', 'cn_name' => '轮播图添加'],
            ['name' => 'slides.show', 'cn_name' => '轮播图详情'],
            ['name' => 'slides.update', 'cn_name' => '轮播图更新'],
            ['name' => 'slides.destroy', 'cn_name' => '轮播图删除'],
            ['name' => 'menus.index', 'cn_name' => '菜单列表'],

        ];
        // 添加角色
        // 为角色添加权限
    }
}
