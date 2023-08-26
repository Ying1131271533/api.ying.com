<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RoomNewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 广播事件时要使用的队列连接的名称
    public $connection = 'redis';
    // 广播作业要放置在哪个队列上的名称
    public $queue = 'room-message';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $data)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // 适合做聊天室
        return new PresenceChannel('room.' . $this->data['user_id']);
    }

    public function broadcastWith()
    {
        return [
            'admin_id' => $this->data['admin_id'],
            'user_id'  => $this->data['user_id'],
            'message'  => $this->data['message'],
            'room'     => 'room.' . $this->data['user_id'],
        ];
    }

    // /**
    //  * 确定事件是否应该广播给频道的其他订阅者。
    //  *
    //  * @param  \Illuminate\Broadcasting\Broadcasters\Broadcaster  $broadcaster
    //  * @return bool
    //  */
    // public function broadcastWhen($broadcaster)
    // {
    //     // 确保不要将消息发送给自己
    //     return $broadcaster->socketId() !== $this->userId;
    // }
}
