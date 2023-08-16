<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SwooleTest implements ShouldBroadcast // 1. 事件是要广播出去的
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 广播事件时要使用的队列连接的名称
    // public $connection = 'rabbitmq';
    public $connection = 'redis';
    // 广播作业要放置在哪个队列上的名称
    public $queue = 'swoole-test';
    // 所有打开的数据库事务提交后被调度
    public $afterCommit = true;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $message)  // 2.广播出去的内容
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // 创建频道
        return new Channel('swoole-test');
        // 私有频道
        // return new PrivateChannel('swoole-test');
        // 适合做聊天室
        // return new PresenceChannel('swoole-test');
    }

    /**
     * 活动的广播名称
     */
    // public function broadcastAs(): string
    // {
    //     // 前端使用时的名称：.server.created
    //     return 'swoole.test';
    // }

    /**
     * 触发事件时返回的数据
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => 1,
            'message' => $this->message,
            'data' => ['name' => '阿卡丽', 'age' => 15]
        ];
    }

    /**
     * 确定此事件是否应该广播
     */
    // public function broadcastWhen(): bool
    // {
    //     return $this->order->value > 100;
    // }
}
