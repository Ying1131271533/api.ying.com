<?php

namespace App\Listeners;

use App\Events\OrderPost;
use App\Mail\OrderPost as MailOrderPost;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SendEmailToOrderUser
{
    protected $validated;
    protected $order;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($validated, Order $order)
    {
        $this->validated = $validated;
        $this->order = $order;
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
        $this->validated['status'] = 3;
        $result = $this->order->fill($this->validated)->save();
        if(!$result) throw new BadRequestException('发货失败！');

        // 发货之后，邮件提醒 - 使用框架的队列
        Mail::to($this->order->user)->queue(new MailOrderPost($this->order));
    }
}
