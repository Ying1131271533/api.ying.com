<?php

namespace App\Listeners;

use App\Events\SendSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class SendCodeForPreconditions
{
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
     * 发送验证码的前提条件
     *
     * @param  \App\Events\SendSms  $event
     * @return void
     */
    public function handle(SendSms $event)
    {
        // 获取短信发送次数
        $sendNumber = Cache::store('redis')->get('phone_code_number:' . $event->phone);

        // 是否有发送记录
        if ($sendNumber) {

            // 获取短信次数是否超过5次
            if ($sendNumber > 4) {
                return abort(400, '每天获取短信验证码不能超过5次');
            }

            // 获取短信时间是否少于一分钟
            $ttl = Cache::store('redis')->get('phone_code_ttl:' . $event->phone);
            if ($ttl) {
                return abort(400, '一分钟内只能获取一次短信');
            }
        }
    }
}
