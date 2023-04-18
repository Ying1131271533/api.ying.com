<?php

use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\UserController;

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

    // 首页数据
    $api->get('index', [IndexController::class, 'index'])->name('index');

    // 需要登录的路由
    $api->group(['middleware' => 'api.auth'], function ($api) {
        /**
         * 个人中心
         */
        // 用户详情
        $api->get('user', [UserController::class, 'userInfo'])->name('user.info');
        // 更新用户信息
        $api->patch('user', [UserController::class, 'updateUserInfo'])->name('user.updateInfo');
    });
});
