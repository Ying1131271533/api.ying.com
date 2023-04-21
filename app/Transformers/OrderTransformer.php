<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        // 可include的模型
        $this->setAvailableIncludes(['user', 'details']);
        return [
            'id'           => $order->id,
            'order_no'     => $order->order_no,
            'user_id'      => $order->user_id,
            'amount'       => $order->amount,
            'status'       => $order->status,
            'address_id'   => $order->address_id,
            'express_type' => $order->express_type,
            'express_no'   => $order->express_no,
            'pay_time'     => $order->pay_time,
            'express_no'   => $order->pay_type,
            'trade_no'     => $order->trade_no,
            'created_at'   => $order->created_at,
            'updated_at'   => $order->updated_at,
        ];
    }

    /**
     * 加载用户数据
     */
    public function includeUser(Order $order)
    {
        return $this->item($order->user, new UserTransformer());
    }

    /**
     * 加载订单详情数据
     */
    public function includeDetails(Order $order)
    {
        return $this->collection($order->details, new OrderDetailsTransformer());
    }
}
