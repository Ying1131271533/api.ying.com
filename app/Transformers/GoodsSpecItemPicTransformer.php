<?php

namespace App\Transformers;

use App\Models\GoodsSpecItemPic;
use League\Fractal\TransformerAbstract;

class GoodsSpecItemPicTransformer extends TransformerAbstract
{
    public function transform(GoodsSpecItemPic $goodsSpecItemPic)
    {
        return [
            'goods_id'     => $goodsSpecItemPic->goods_id,
            'spec_item_id' => $goodsSpecItemPic->spec_item_id,
            'path'         => $goodsSpecItemPic->path,
        ];
    }
}
