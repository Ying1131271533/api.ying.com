<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderSubmit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // 队列连接的名称
    public $connection = 'rabbtimq';
    // 队列使用上的名称
    public $queue = 'order.submit';
    // 只能在数据库事务提交后被调度
    // public $afterCommit = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 订单是否未支付
        if($this->order->status == 1) {
            $this->order->status = 5;
            $this->order->save();
        }
    }
}
