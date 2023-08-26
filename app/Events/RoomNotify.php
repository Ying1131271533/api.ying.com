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

class RoomNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 广播事件时要使用的队列连接的名称
    public $connection = 'redis';
    // 广播作业要放置在哪个队列上的名称
    public $queue = 'room-notify';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $data)
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
        return new PrivateChannel('admin.' . $this->data['admin_id']);
    }

    public function broadcastWith()
    {
        return [
            'user_id'   => $this->data['user_id'],
            'user_name' => $this->data['user_name'],
            // 'problem' => $this->data['problem'],
            'messages'  => $this->data['messages'],
            'room'      => 'room.' . $this->data['user_id'],
        ];
    }
}
