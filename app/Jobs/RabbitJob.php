<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class RabbitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // 队列连接的名称
    // public $connection = 'rabbtimq';
    // 队列使用上的名称
    // public $queue = 'rabbit.job';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $data)
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 打印内容
        echo json_encode([
            'code' => 200,
            'msg' => 'success',
            'data' => $this->data
        ], JSON_UNESCAPED_UNICODE);
        // try {
        //     echo json_encode(['code' => 200, 'msg' => 'success', 'data' => $this->data], JSON_UNESCAPED_UNICODE);
        // } catch (\Exception $e) {
        //     echo json_encode(['code' => $e->getCode(), 'msg' => $e->getMessage(), 'data' => null], JSON_UNESCAPED_UNICODE);
        // }
    }

    /**
     * 处理失败作业
     */
    // public function failed($exception = null): void
    public function failed(Throwable $exception): void
    {
        // 向用户发送失败通知等...
        if ($exception instanceof \Exception ) {
            file_put_contents('akali.log', $exception->getTraceAsString());
        }
    }
}
