<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// 该channel永远返回true意味着无论收听者是谁，他都会收听到最新的广播。
Broadcast::channel('swoole-test', function ($user, $id) {
    return true;
});
// }, ['guards' => ['api', 'admin']]);

// 如果这个订单id是用户拥有的，则可以收听广播
// Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
//     return $user->id === Order::findOrNew($orderId)->user_id;
// });
