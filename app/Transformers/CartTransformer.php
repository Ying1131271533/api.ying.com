<?php

namespace App\Transformers;

use App\Models\Cart;
use App\Models\GoodsSpec;
use App\Models\SpecItem;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    public function transform(Cart $cart)
    {
        // 可include的模型
        $this->setAvailableIncludes(['goods']);

        return [
            'id'            => $cart->id,
            'user_id'       => $cart->user_id,
            'goods_id'      => $cart->goods_id,
            'spec'          => $cart->spec,
            'spec_name'     => $cart->spec_name,
            'number'        => $cart->number,
            'is_checked'    => $cart->is_checked,
            // 'show_specs'    => $cart->show_specs,
            'spec_item_pic' => $cart->spec_item_pic,
        ];
    }

    /**
     * 加载商品数据
     */
    public function includeGoods(Cart $cart)
    {
        return $this->item($cart->goods, new GoodsTransformer());
    }
}
