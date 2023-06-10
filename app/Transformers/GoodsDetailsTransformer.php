<?php

namespace App\Transformers;

use App\Models\GoodsDetails;
use League\Fractal\TransformerAbstract;

class GoodsDetailsTransformer extends TransformerAbstract
{
    public function transform(GoodsDetails $goodsDetails)
    {
        return [
            'goods_id' => $goodsDetails->goods_id,
            'pics'     => $goodsDetails->pics,
            'content'  => $goodsDetails->content,
        ];
    }

}
