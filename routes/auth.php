<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api) {
    // 路由组
    $api->group(['prefix' => 'auth'], function ($api) {
        // 用户注册
        $api->post('register', [RegisterController::class, 'store']);
        // 用户登录
        $api->post('login', [LoginController::class, 'login']);

        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->get('user/{id}', [Login::class, 'index'])->name('v1.user.index');
        });
    });

});
