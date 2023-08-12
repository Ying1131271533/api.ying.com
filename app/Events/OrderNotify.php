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

class OrderNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $goods)
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
        return new Channel('order-notify');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->goods->id,
            'title' => $this->goods->title,
            'message'  => '订单已提交',
        ];
        // return [
        //     'order_id' => $this->order->id,
        //     'user_id' => $this->order->user_id,
        //     'order_no' => $this->order->order_no,
        //     'amount' => $this->order->amount,
        //     'message'  => '订单已提交',
        // ];
    }
}
