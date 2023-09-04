<?php

namespace App\Transformers;

use App\Models\OrderGoods;
use League\Fractal\TransformerAbstract;

class OrderGoodsTransformer extends TransformerAbstract
{
    public function transform(orderGoods $orderGoods)
    {
        // 可include的模型
        $this->setAvailableIncludes(['order', 'goods']);
        return [
            'id'         => $orderGoods->id,
            'order_id'   => $orderGoods->order_id,
            'goods_id'   => $orderGoods->goods_id,
            'shop_price' => $orderGoods->shop_price,
            'market_price'      => $orderGoods->market_price,
            'spec'     => $orderGoods->spec,
            'number'     => $orderGoods->number,
            'spec_name'     => $orderGoods->spec_name,
            'created_at' => $orderGoods->created_at,
            'updated_at' => $orderGoods->updated_at,
        ];
    }

    /**
     * 加载订单数据
     */
    public function includeOrder(orderGoods $orderGoods)
    {
        return $this->item($orderGoods->order, new OrderTransformer());
    }

    /**
     * 加载商品数据
     */
    public function includeGoods(orderGoods $orderGoods)
    {
        return $this->item($orderGoods->goods, new GoodsTransformer());
    }
}
