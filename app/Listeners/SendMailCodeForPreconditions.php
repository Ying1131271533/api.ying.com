<?php

namespace App\Listeners;

use App\Events\SendMailCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class SendMailCodeForPreconditions
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
     * Handle the event.
     *
     * @param  \App\Events\SendMailCode  $event
     * @return void
     */
    public function handle(SendMailCode $event)
    {
        // 获取邮件验证码发送次数
        $sendNumber = Cache::store('redis')->get('email_code_number:' . $event->email);

        // 是否有发送记录
        if ($sendNumber) {

            // 获取邮件验证码次数是否超过5次
            if ($sendNumber > 4) {
                return abort(400, '每天获取邮件验证码不能超过5次');
            }

            // 获取邮件验证码时间是否少于一分钟
            $ttl = Cache::store('redis')->get('email_code_ttl:' . $event->email);
            if ($ttl) {
                return abort(400, '一分钟内只能获取一次邮件验证码');
            }
        }
    }
}
