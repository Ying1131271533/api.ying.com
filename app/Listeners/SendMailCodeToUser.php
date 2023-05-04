<?php

namespace App\Listeners;

use App\Events\SendMailCode;
use App\Mail\SendCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendMailCodeToUser
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
        // 发送验证码到邮箱
        Mail::to($event->email)->queue(new SendCode($event->email, $event->code));
        // 延迟
        //  Mail::to($event->email)->later(now()->addMinutes(1), new SendCode($event->email, $event->code));

        // 缓存验证码，过期时间15分钟
        Cache::store('redis')->put('email_code:' . $event->email, $event->code, now()->addMinute(15));

        // 记录次数的缓存，过期时间明天凌晨0点
        if (!Cache::store('redis')->has('email_code_number:' . $event->email)) {
            Cache::store('redis')->set('email_code_number:' . $event->email, 0, now()->tomorrow());
        }

        // 发送次数加一
        Cache::store('redis')->increment('email_code_number:' . $event->email);

        // 记录一分钟内获取了短信
        Cache::store('redis')->set('email_code_ttl:' . $event->email, 1, now()->addMinute(1));
    }
}
