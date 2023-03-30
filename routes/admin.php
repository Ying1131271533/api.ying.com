<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => [
        'api.throttle',
        'bindings', // 支持模型注入
        'serializer:default_array', // 去掉 transformer 的包裹层
    ],
    'limit'      => 60,
    'expires' => 1,
];

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
        });
    });

});
