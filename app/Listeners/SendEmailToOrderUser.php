<?php

namespace App\Listeners;

use App\Events\OrderPost;
use App\Mail\OrderPost as MailOrderPost;
use App\Mail\OrderPosts as MailOrderPosts;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SendEmailToOrderUser
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
     * @param  \App\Events\OrderPost  $event
     * @return void
     */
    public function handle(OrderPost $event)
    {
        // 发货状态
        $event->validated['status'] = 3;
        $result = $event->order->fill($event->validated)->save();
        if(!$result) throw new BadRequestException('发货失败！');

        // 发货之后，邮件提醒 - 使用框架的队列
        Mail::to($event->order->user)->queue(new MailOrderPost($event->order));
    }
}
