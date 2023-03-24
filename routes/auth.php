<?php

use App\Http\Controllers\Auth\RegisterController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api) {
    // 路由组
    $api->group(['prefix' => 'auth'], function ($api) {
        // 用户注册
        $api->post('register', [RegisterController::class, 'store'])->name('v1.auth.register');
        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function ($api) {

        });
    });

});
