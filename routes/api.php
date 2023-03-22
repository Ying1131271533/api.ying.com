<?php

// 为了避免主要应用程序路由复杂化，这个包使用了自己的路由器
// 因此，我们必须首先获取 API 路由器的实例来创建我们的端点。

use App\Http\Controllers\TestController;

$api = app('Dingo\Api\Routing\Router');

// 我们现在必须定义一个版本组。如果我们需要在轨道上进行更改，这允许我们为多个版本创建相同的端点。
$api->version('v1', function ($api) {
    $api->get('test', [TestController::class, 'index']);
    $api->get('name', ['as' => 'test.name', 'uses' => 'App\Http\Controllers\TestController@name']);
});

$api->version('v2', function ($api) {

});













