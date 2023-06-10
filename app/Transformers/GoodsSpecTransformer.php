<?php

namespace App\Transformers;

use App\Models\GoodsSpec;
use League\Fractal\TransformerAbstract;

class GoodsSpecTransformer extends TransformerAbstract
{
    public function transform(GoodsSpec $goodsSpec)
    {
        return [
            'id'            => $goodsSpec->id,
            'goods_id'      => $goodsSpec->goods_id,
            'item_ids'      => $goodsSpec->item_ids,
            'item_ids_name' => $goodsSpec->item_ids_name,
            'spec_price'    => $goodsSpec->spec_price,
            'stock'         => $goodsSpec->stock,
            'sales'         => $goodsSpec->sales,
            'created_at'    => $goodsSpec->created_at,
            'updated_at'    => $goodsSpec->updated_at,
        ];
    }
}
