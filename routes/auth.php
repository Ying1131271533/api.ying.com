<?php

use App\Http\Controllers\Auth\BindController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OssController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api) {
    // 路由组
    $api->group(['prefix' => 'auth'], function ($api) {
        // 用户注册
        $api->post('register', [RegisterController::class, 'store'])->name('auth.register');
        // 用户登录
        $api->post('login', [LoginController::class, 'login'])->name('auth.login');

        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function ($api) {
            // 退出登录
            $api->post('logout', [LoginController::class, 'logout'])->name('auth.logout');
            // 刷新token
            $api->get('refresh', [LoginController::class, 'refresh'])->name('auth.refresh');

            // 阿里云OSS Token
            $api->get('oss-token', [OssController::class, 'token'])->name('auth.oss-token');
            // 修改密码
            $api->patch('password/update', [PasswordController::class, 'updatePassword'])->name('auth.updatePassword');
            // 发送邮件验证码
            $api->post('email/code', [BindController::class, 'emailCode'])->name('auth.emailCode');
            // 修改邮箱
            $api->post('email/update', [BindController::class, 'updateEmail'])->name('auth.updateEmail');
        });
    });

});
