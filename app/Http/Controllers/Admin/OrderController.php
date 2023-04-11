<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderPost as EventsOrderPost;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\OrderRequest;
use App\Mail\OrderPost;
use App\Mail\OrderPosts;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends BaseController
{
    /**
     * 订单列表
     */
    public function index(Request $request)
    {
        // 查询条件
        $order_no = $request->query('order_no');
        $trade_no = $request->query('trade_no');
        $status = $request->query('status');

        $orders = Order::when($order_no, function($query) use ($order_no) {
            $query->where('order_no', $order_no);
        })
        ->when($trade_no, function($query) use ($trade_no) {
            $query->where('trade_no', $trade_no);
        })
        ->when($status, function($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate(1);
        return $this->response->paginator($orders, new OrderTransformer);
    }

    /**
     * 订单详情
     */
    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransformer);
    }

    /**
     * 发货
     */
    public function post(OrderRequest $request, Order $order)
    {
        // 过滤的参数
        $validated = $request->validated();

        // 常规发货
        // $validated = $request->validated();
        // // 发货状态
        // $validated['status'] = 3;
        // $result = $order->fill($validated)->save();
        // if(!$result) return $this->response->errorInternal('发货失败！');

        // // 发货之后，邮件提醒 - 使用框架的队列
        // Mail::to($order->user)->queue(new OrderPost($order));

        // 使用事件分发
        event(new EventsOrderPost($validated, $order));
        EventsOrderPost::dispatch($validated, $order);

        return $this->response->noContent();
    }
}
