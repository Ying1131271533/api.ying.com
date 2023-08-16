<?php

use App\Http\Controllers\Auth\BindController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OssController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UploadController;

$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => 'api.throttle',
    'limit' => 60,
    'expires' => 1
];

$api->version('v1', $params, function ($api) {
    // 路由组
    $api->group(['prefix' => 'auth'], function ($api) {
        // 用户注册
        $api->post('register', [RegisterController::class, 'store'])->name('auth.register');
        // 用户登录
        $api->post('login', [LoginController::class, 'login'])->name('auth.login');

        // 找回密码 通过邮箱发送验证码
        $api->post('reset/password/email/code', [PasswordResetController::class, 'emailCode'])->name('auth.resetPassword.emailCode');
        // 提交邮箱和验证码，修改密码
        $api->patch('reset/password/email', [PasswordResetController::class, 'resetPasswordByEmail'])->name('auth.resetPasswordByEmail');

        // 找回密码 通过手机发送验证码
        $api->post('reset/password/sms/code', [PasswordResetController::class, 'smsCode'])->name('auth.resetPassword.smsCode');
        // 提交手机和验证码，修改密码
        $api->patch('reset/password/sms', [PasswordResetController::class, 'resetPasswordBySms'])->name('auth.resetPasswordBySms');

        // 需要登录的路由
        $api->group(['middleware' => ['api.auth']], function ($api) {
        // $api->group(['middleware' => ['api.auth', 'check.permission']], function ($api) {
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
            $api->patch('email/update', [BindController::class, 'updateEmail'])->name('auth.updateEmail');
            // 发送手机验证码
            $api->post('phone/code', [BindController::class, 'phoneCode'])->name('auth.phoneCode');
            // 修改手机号
            $api->patch('phone/update', [BindController::class, 'updatePhone'])->name('auth.updatePhone');
            // 上传文件
            $api->post('upload', UploadController::class)->name('auth.upload');
        });
    });

});
