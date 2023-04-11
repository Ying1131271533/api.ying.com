<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GoodsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TestController;

$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => [
        'api.throttle',
        'bindings', // 支持模型注入
        'serializer:default_array', // 去掉 transformer 的包裹层
    ],
    'limit'      => 60, // 有效时间内能够访问的次数
    'expires' => 1, // 有效时间/分钟
];
$api->get('test', [TestController::class, 'index']);
$api->version('v1', $params, function ($api) {

    // 前缀
    $api->group(['prefix' => 'admin'], function ($api) {

        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function ($api) {

            /**
             * 用户管理
             */
            // 用户 启用/禁用
            $api->patch('users/{user}/lock', [UserController::class, 'lock']);
            // 用户管理资源路由
            $api->resource('users', UserController::class, ['only' => [
                'index', 'show',
            ]]);

            /**
             * 分类管理
             */
            // 分类 启用/禁用
            $api->patch('categorys/{category}/status', [CategoryController::class, 'status']);
            // 分类管理资源路由
            $api->resource('categorys', CategoryController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 商品管理
             */
            // 商品上架
            $api->patch('goods/{good}/on', [GoodsController::class, 'isOn']);
            // 推荐商品
            $api->patch('goods/{good}/recommend', [GoodsController::class, 'isRecommend']);
            // 商品管理资源路由
            $api->resource('goods', GoodsController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 评论管理
             */
            // 评价列表
            $api->get('comments', [CommentController::class, 'index']);
            // 评价详情
            $api->get('comments/{comment}', [CommentController::class, 'show']);
            // 商家回复
            $api->patch('comments/{comment}/reply', [CommentController::class, 'reply']);

            /**
             * 订单管理
             */
            // 订单列表
            $api->get('orders', [OrderController::class, 'index']);
            // 订单详情
            $api->get('orders/{order}', [OrderController::class, 'show']);
            // 订单发货
            $api->patch('orders/{order}/post', [OrderController::class, 'post']);
        });
    });

});
