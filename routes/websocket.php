<?php

use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('connect', function ($websocket, Request $request) {
    // called while socket on connect
    $websocket->emit('message', '需要连接成功返回的数据');
    // $websocket->emit('我是服务器这边链接成功的消息', [123]);
    // Websocket::loginUsingId(2);
    // info('message', ['name' => $request->bearerToken()]);
    // info('message', ['name' => $user]);

    // 获取身份验证用户
    // auth()->user();
});
// })->middleware(App\Http\Middleware\SetBearerToRequestHeader::class);
// })->middleware(FooBarMiddleware::class);

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
    $websocket->emit('message', '已经断开链接');
});

Websocket::on('example', function ($websocket, $data) {
    // 仅发送到发件人客户端
    // $websocket->emit('message', $data);
    info('message', ['name' => '锐雯']);
    // 发送到除发件人之外的所有客户端
    $websocket->broadcast()->emit('message', 'this is a test');
});

Websocket::on('test', function ($websocket, $data) {
    info('message', ['name' => $data]);
    $websocket->emit('message', '测试');
});

/**
 * 定义一个login路由，指向控制器方法，和http类似
 */
Websocket::on('login','App\Http\Controllers\Index\LoginController@index');
