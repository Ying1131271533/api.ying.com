<?php

namespace App\Transformers;

use App\Models\OrderDetails;
use League\Fractal\TransformerAbstract;

class OrderDetailsTransformer extends TransformerAbstract
{
    public function transform(OrderDetails $orderDetails)
    {
        // 可include的模型
        $this->setAvailableIncludes(['order', 'goods']);
        return [
            'id'         => $orderDetails->id,
            'order_id'   => $orderDetails->order_id,
            'goods_id'   => $orderDetails->goods_id,
            'price'      => $orderDetails->price,
            'number'     => $orderDetails->number,
            'created_at' => $orderDetails->created_at,
            'updated_at' => $orderDetails->updated_at,
        ];
    }

    /**
     * 加载订单数据
     */
    public function includeOrder(OrderDetails $orderDetails)
    {
        return $this->item($orderDetails->order, new OrderTransformer());
    }

    /**
     * 加载商品数据
     */
    public function includeGoods(OrderDetails $orderDetails)
    {
        return $this->item($orderDetails->goods, new GoodsTransformer());
    }
}
