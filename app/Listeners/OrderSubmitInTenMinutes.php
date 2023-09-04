<?php

namespace App\Listeners;

use App\Events\OrderSubmit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderSubmitInTenMinutes implements ShouldQueue
{
    /**
     * 任务将被发送到的连接的名称。
     *
     * @var string|null
     */
    public $connection = 'rabbtimq';

    /**
     * 任务将被发送到的队列的名称。
     *
     * @var string|null
     */
    // public $queue = 'listeners';

    /**
     * 任务被处理的延迟时间（秒）。
     *
     * @var int
     */
    public $delay = 600;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderSubmit  $event
     * @return void
     */
    public function handle(OrderSubmit $event)
    {
        // 订单是否未支付
        if($event->order->status == 1) {
            $event->order->status = 5;
            $event->order->save();
        }
    }
}
