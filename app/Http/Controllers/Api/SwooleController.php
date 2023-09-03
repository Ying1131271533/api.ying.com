<?php

namespace App\Http\Controllers\Api;

use App\Events\RoomNewMessage;
use App\Events\OrderDispatch;
use App\Events\OrderPay;
use App\Events\RoomNotify;
use App\Events\SwooleTest;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ChatMessageRequest;
use App\Models\Goods;
use App\Models\Mongo\Book;
use App\Models\Mongo\Chat;
use App\Models\Order;
use App\Transformers\ChatMessagesTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use SwooleTW\Http\Websocket\Facades\Websocket;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class SwooleController extends BaseController
{
    public function __construct()
    {
        // 如果路由那边出现问题就用这里
        // $this->middleware('auth.api');
    }

    /**
     * 测试
     */
    public function test($websocket, $data, Request $request)
    {
        // SwooleTest::dispatch('你好啊！阿卡丽');
        // info('message', ['data' => json_decode($data)]);
        // dump($data);
        // array:2 [
        //     "text" => "i say hey"
        //     "token" => "eyJ0eXAiO......"
        // ]
        dump($data['token']);
        // $request->headers->set('Authorization', 'Bearer ' . $data['token']);
        // $token = $this->jwt->getToken();
        // dump($token);
        // $user = auth('api')->setToken($data['token']);
        // dump($user);
        // $user = auth()->setToken($data['token'])->user();
        // dump($user);
        // broadcast(new SwooleTest('你好啊！'));
        // 只发给其他人
        // broadcast(new SwooleTest('你好啊！'))->toOthers();

        $websocket->emit('akali', "我收到了你的消息：" . $data);
        return '发送成功';
    }

    /**
     * 订单支付通知
     */
    public function orderPay()
    {
        $order = Order::find(1);
        OrderPay::dispatch($order);
        // broadcast(new OrderPay($order));
        return '发送成功';
    }

    /**
     * 订单发货通知
     */
    public function orderDispatch()
    {
        $order = Order::find(2);
        OrderDispatch::dispatch($order);
        // broadcast(new OrderDispatch($order));
        return '发送成功';
    }

    // 这里是用户发送的申请客服回答问题的请求
    public function roomNotify()
    {
        // 在redis获取在线的客服id
        $admin_id = 1;

        // 保存room信息到redis
        $room = [
            'admin_id' => $admin_id,
            'user_id' => auth()->id(),
        ];
        Cache::store('redis')->add('room:room.'.auth()->id(), $room, cache_time());

        // 用户发送来的数据
        $data = [
            'admin_id' => $admin_id,
            'user_id' => auth()->id(),
            'user_name' => 'akali',
            // 'problem' => '怎么下单？',
            'messages' => '怎么下单？',
        ];

        // 发送队列
        RoomNotify::dispatch($data);

        // 保存到mongo 发送消息那里保存，这里只提示管理员有客服申请
        // unset($data['user_name']);
        // $chat = Chat::create([
        //     'admin_id' => 1,
        //     'user_id' => 2,
        //     'messages' => '怎么下单？',
        // ]);

        // 返回
        return $this->response->noContent();
    }

    public function roomNewMessage(ChatMessageRequest $request)
    {
        // 接收聊天信息数据
        $validated = $request->validated();
        // 获取聊天室信息
        $room = Cache::get('room:' . $validated['room']);
        // 如果没有聊天室，则说明用户今天没有申请客服聊天
        if(empty($room)) {
            // 在redis获取在线的客服id
            // $online_admins = Cache::store('redis')->get('online_admin');
            // $admin = array_rand($online_admins);
            // $admin_id = $admin['id'];
            $admin_id = 1;
             // 保存room信息到redis
            $room = [
                'admin_id' => $admin_id,
                'user_id' => auth()->id(),
            ];
            Cache::store('redis')->add('room:room.'.auth()->id(), $room, cache_time());

            // 如果是用户，则通知管理员
            if(!empty(auth()->id())){
                // 通知信息
                $data = [
                    'user_name' => auth()->user()->name,
                    'messages' => $validated['message'],
                ];
                $data = array_merge($data, $room);
                // 发送队列 - 通知管理员
                RoomNotify::dispatch($data);
            }
        }

        // 合并
        $data = array_merge($validated, $room);

        // 保存到mongo
        unset($data['room']);
        // 如果是客户的则标记上
        $data['is_user'] = !empty(auth('api')->id()) ? 1 : 0;
        $chat = Chat::create($data);

        // 排除当前用户接收广播
        broadcast(new RoomNewMessage($data))->toOthers();

        return $this->response->noContent();
    }

    // 获取聊天信息
    public function roomChatMessages(Request $request)
    {
        $user_id = (int) $request->query('user_id');
        $chatMessages = Chat::where('user_id', $user_id)->get();
        return $this->response->collection($chatMessages, new ChatMessagesTransformer);
    }


}
