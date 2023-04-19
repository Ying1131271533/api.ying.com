<?php

namespace App\Listeners;

use App\Events\SendSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

class SendCodeToUser implements ShouldQueue
{
    /**
     * 任务将被发送到的连接的名称。
     *
     * @var string|null
     */
    // public $connection = 'redis';

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
    // public $delay = 1;

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
     * @param  \App\Events\SendSms  $event
     * @return void
     */
    public function handle(SendSms $event)
    {
        // 获取短信是否超过5次
        $sendNumber = Cache::store('redis')->get('phone_code_number:' . $event->phone);
        if(!empty($sendNumber) && $sendNumber > 4) {
            return abort(400, '每天获取短信验证码不能超过5次');
        }

        // 获取sms配置
        $config = config('sms');
        $easySms = new EasySms($config);

        // 验证码
        $code = make_code(4);

        try {
            // 发送验证码到手机
            $easySms->send($event->phone, [
                // 短信模版
                'template' => $config['template']['ordinary'],
                // 看短信模版有几个变量，就填几个变量
                'data' => [
                    'code' => $code,
                    // 'type' => $event->type,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getExceptions(), 400);
        }

        // 缓存验证码
        Cache::store('redis')->put('phone_code:' . $event->phone, $code, now()->addMinute(15));
        // 缓存验证码次数加一
        Cache::store('redis')->incr('phone_code_number:' . $event->phone);
    }
}
