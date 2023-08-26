<?php

use App\Broadcasting\OrderNotifyChannel;
use App\Models\Admin;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

// 这行代码必需有，不然laravel-echo-server不会走这里
Broadcast::routes();
// Broadcast::routes(['middleware' => 'auth:api']);
// Broadcast::routes(['middleware' => 'auth:admin']);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// }, ['guards' => ['api', 'admin']]); // 选择一个看守器，或者两个都用

// 定义频道类
// Broadcast::channel('user.{userId}', OrderNotifyChannel::class, ['guards' => ['api', 'admin']]);

/******************************** api ********************************/


// 该channel永远返回true意味着无论收听者是谁，他都会收听到最新的广播。
Broadcast::channel('swoole-test', function ($user, $id) {
    return true;
});

// 如果这个订单id是用户拥有的，则可以收听广播
// Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
//     return $user->id === Order::findOrNew($orderId)->user_id;
// }, ['guards' => ['api', 'admin']]);

// 用户监听所有属于自己的频道
Broadcast::channel('user.{userId}', function (User $user, int $userId) {
    // Log::info('用户id：', ['id' => $userId]);
    // Log::info('用户对象：', $user->toArray());
    return (int) $user->id === (int) $userId;
}, ['guards' => 'api']);


/******************************** admin ********************************/

// 管理员监听所有属于自己的频道
Broadcast::channel('admin.{adminId}', function (Admin $admin, int $adminId) {
    // Log::info('管理员id：', ['id' => $adminId]);
    // Log::info('管理员对象：', $admin->toArray());
    return (int) $admin->id === (int) $adminId;
}, ['guards' => 'admin']);

// 聊天室
Broadcast::channel('room.{roomId}', function ($user, int $roomId) {
    // if ($user->canJoinRoom($roomId)) {
    //     return ['id' => $user->id, 'name' => $user->name];
    // }
    $room = Cache::store('redis')->get('room:room.'.$roomId);
    // Log::info($room);
    if($user->id === $room['user_id'] || $user->id === $room['admin_id']){
        return ['id' => $user->id, 'name' => $user->name];
    }
}, ['guards' => ['api', 'admin']]); // 管理员和用户都可以进来
