<?php

namespace App\Listeners;

use App\Events\SendSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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
        // 获取sms配置
        $config = config('sms');
        $easySms = new EasySms($config);

        try {
            // 发送验证码到手机
            $easySms->send($event->phone, [
                // 短信模版
                'template' => $config['template']['ordinary'],
                // 看短信模版有几个变量，就填几个变量
                'data' => [
                    'code' => $event->code,
                    // 'type' => $event->type,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('短信发送失败-'.$event->phone, $e->getExceptions());
            // 打印错误信息
            // dd($e->getExceptions());
        }

        // 缓存验证码，过期时间15分钟
        Cache::store('redis')->put('phone_code:' . $event->phone, $event->code, now()->addMinute(15));

        // 记录次数的缓存，过期时间明天凌晨0点
        if (!Cache::store('redis')->has('phone_code_number:' . $event->phone)) {
            Cache::store('redis')->set('phone_code_number:' . $event->phone, 0, now()->tomorrow());
        }

        // 发送次数加一
        Cache::store('redis')->increment('phone_code_number:' . $event->phone);

        // 记录一分钟内获取了短信
        Cache::store('redis')->set('phone_code_ttl:' . $event->phone, 1, now()->addMinute(1));
    }
}
