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

    // 获取身份验证用户
    // $request->user();
    // auth()->user();
});
// })->middleware(FooBarMiddleware::class);

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
    $websocket->emit('message', '已经断开链接');
});

Websocket::on('example', function ($websocket, $data) {
    // 仅发送到发件人客户端
    // $websocket->emit('message', $data);
    // 发送到除发件人之外的所有客户端
    $websocket->broadcast()->emit('message', 'this is a test');
});
