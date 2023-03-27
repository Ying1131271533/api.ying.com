<?php

use App\Http\Controllers\Admin\UserController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api) {

    // 前缀
    $api->group(['prefix' => 'admin'], function($api){

        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function ($api) {
            /**
             * 用户管理
             */
            // 用户 启用/禁用
            $api->patch('users/{user}/lock', [UserController::class, 'lock']);
            // 用户管理资源路由
            $api->resource('users', UserController::class, ['only' => [
                'index', 'show'
            ]]);
        });
    });

});
