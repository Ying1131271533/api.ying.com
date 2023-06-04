<?php

namespace App\Transformers;

use App\Models\GoodsType;
use League\Fractal\TransformerAbstract;

class GoodsTypeTransformer extends TransformerAbstract
{
    public function transform(GoodsType $goodsType)
    {
        return [
            'id'         => $goodsType->id,
            'name'       => $goodsType->name,
            'created_at' => $goodsType->created_at,
            'updated_at' => $goodsType->updated_at,
        ];
    }
}
