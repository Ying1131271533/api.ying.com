<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CitieController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\GoodsController;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PayController;
use App\Http\Controllers\Api\SwooleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ElasticsearhController;
use App\Http\Controllers\TestController;

$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => [
        // 'cross.domain', // 允许哪些域名访问，文件在 Kernel.php 注册 ，不开启则是允许跨域
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
    $api->get('test/es', [TestController::class, 'es'])->name('es');
    $api->get('test/mongo', [TestController::class, 'mongo'])->name('mongo');
    $api->get('test/rabbitmq', [TestController::class, 'rabbitmq'])->name('rabbitmq');
    $api->get('test/swoole', [TestController::class, 'swoole'])->name('swoole');

    // 首页数据
    $api->get('index', [IndexController::class, 'index'])->name('index');

    // 商品详情
    $api->get('goods/{good}', [GoodsController::class, 'show'])->name('goods.show');

    // 商品列表
    $api->get('goods', [GoodsController::class, 'index'])->name('goods.index');
    // es搜素商品列表
    $api->get('goods-es-index', [GoodsController::class, 'esIndex'])->name('goods.esIndex');

    /**
     * 回调
     */
    // 支付宝支付成功之后异步的回调
    $api->any('pay/notify/alipay', [PayController::class, 'notifyAlipay'])->name('pay.notifyAlipay');
    // 支付宝支付成功之后异步的回调
    $api->any('pay/return/alipay', [PayController::class, 'returnAlipay'])->name('pay.returnAlipay');

    // 微信支付成功之后异步的回调
    $api->any('pay/notify/wechat', [PayController::class, 'notifyWechat'])->name('pay.notifyWechat');

    // 信息
    $api->get('swoole/messages', [SwooleController::class, 'messages'])->name('swoole.messages');

    // 需要登录的路由
    $api->group(['middleware' => 'api.auth'], function ($api) {

        /**
         * Laravel-Swoole
         */
        // 授权
        $api->post('swoole/auth', [SwooleController::class, 'auth'])->name('swoole.auth');
        // 测试
        $api->post('swoole/test', [SwooleController::class, 'test'])->name('swoole.test');
        // 消息通知
        $api->post('swoole/notify', [SwooleController::class, 'notify'])->name('swoole.notify');
        // 聊天室
        $api->post('swoole/room', [SwooleController::class, 'room'])->name('swoole.room');

        /**
         * 个人中心
         */
        // 用户详情
        $api->get('user', [UserController::class, 'userInfo'])->name('user.info');
        // 更新用户信息
        $api->patch('user', [UserController::class, 'updateUserInfo'])->name('user.updateInfo');
        // 更新用户头像
        $api->patch('user/avatar', [UserController::class, 'updateUserAvatar'])->name('user.updateAvatar');
        // 根据用户id获取用户
        $api->get('user/get-user-by-id/{user}', [UserController::class, 'getUserById'])->name('user.getUserById');

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
        // 预览页
        $api->get('orders/preview', [OrderController::class, 'preview'])->name('order.preview');
        // 提交
        $api->post('orders', [OrderController::class, 'store'])->name('order.store');
        // 详情页
        $api->get('orders/{order}', [OrderController::class, 'show'])->name('order.show');
        // 列表
        $api->get('orders', [OrderController::class, 'index'])->name('order.index');
        // 物流查询
        $api->get('orders/{order}/express', [OrderController::class, 'express'])->name('order.express');
        // 确认收货
        $api->patch('orders/{order}/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
        // 评价
        $api->post('comments/{order}', [CommentController::class, 'store'])->name('comments.store');

        /**
         * 支付
         */
        // 获取支付信息
        $api->get('orders/{order}/pay', [PayController::class, 'pay'])->name('order.pay');
        // 轮询查询支付状态
        $api->get('orders/{order}/status', [PayController::class, 'payStatus'])->name('order.payStatus');

        /**
         * 地址
         */
        // 城市数据
        $api->get('cities', [CitieController::class, 'index'])->name('cities.index');
        // 默认收货地址
        $api->patch('address/{address}/default', [AddressController::class, 'default'])->name('address.default');
        // 收货地址的资源路由
        $api->resource('address', AddressController::class);

    });
});
