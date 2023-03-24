<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api) {

    // 需要登录的路由
    $api->group(['middleware' => 'api.auth'], function ($api) {

    });
});
