<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\GoodsController;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\TestController;

$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => [
        'api.throttle',
        'bindings', // 支持模型注入
        'serializer:default_array', // 去掉 transformer 的包裹层
    ],
    'limit'   => 60, // 有效时间内能够访问的次数
    'expires' => 1, // 有效时间/分钟
];

$api->version('v1', $params, function ($api) {

    // 测试
    $api->get('test', [TestController::class, 'index'])->name('test');

    // 首页数据
    $api->get('index', [IndexController::class, 'index'])->name('index');

    // 商品详情
    $api->get('goods/{good}', [GoodsController::class, 'show'])->name('goods.show');

    // 商品列表
    $api->get('goods', [GoodsController::class, 'index'])->name('goods.index');


    // 需要登录的路由
    $api->group(['middleware' => 'api.auth'], function ($api) {

        /**
         * 个人中心
         */
        // 用户详情
        $api->get('user', [UserController::class, 'userInfo'])->name('user.info');
        // 更新用户信息
        $api->patch('user', [UserController::class, 'updateUserInfo'])->name('user.updateInfo');
        // 更新用户头像
        $api->patch('user/avatar', [UserController::class, 'updateUserAvatar'])->name('user.updateAvatar');

        /**
         * 购物车
         */
        // 选中
        $api->patch('carts/{cart}/checked', [CartController::class, 'isChecked']);
        // 资源路由
        $api->resource('carts', CartController::class, [
            'except' => ['show']
        ]);

        /**
         * 订单
         */
        // 订单预览页
        $api->get('orders/preview', [OrderController::class, 'preview'])->name('order.preview');
        // 提交订单
        $api->post('orders', [OrderController::class, 'store'])->name('order.store');
    });
});
