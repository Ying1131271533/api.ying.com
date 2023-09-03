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
    $websocket->emit('test', '连接成功');
    // info('message', ['query' => request()->headers]);
    // Websocket::loginUsingId(2);
});
// })->middleware(App\Http\Middleware\SetBearerToRequestHeader::class);
// })->middleware(PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate::class);

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
    $websocket->emit('message', '已经断开链接');
});

Websocket::on('test', function ($websocket, $data) {
    info('message', ['test' => '阿卡丽11']);
    $websocket->emit('akali', '阿卡丽');
});

/**
 * 定义一个login路由，指向控制器方法，和http类似
 */
Websocket::on('login', 'App\Http\Controllers\Api\SwooleController@test');
