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

class OrderPay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 广播事件时要使用的队列连接的名称
    public $connection = 'redis';
    // 广播作业要放置在哪个队列上的名称
    public $queue = 'order-notify';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Order $order)
    // public function __construct(public Order $order)
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
        return new PrivateChannel('user.' . $this->order->user_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'order_no' => $this->order->order_no,
            'status' => $this->order->status,
        ];
    }
}
