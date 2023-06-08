<?php

namespace App\Transformers;

use App\Models\GoodsType;
use League\Fractal\TransformerAbstract;

class GoodsTypeTransformer extends TransformerAbstract
{
    public function transform(GoodsType $goodsType)
    {
        $this->setAvailableIncludes(['attributes', 'specs']);

        return [
            'id'         => $goodsType->id,
            'name'       => $goodsType->name,
            'created_at' => $goodsType->created_at,
            'updated_at' => $goodsType->updated_at,
        ];
    }


    /**
     * 加载商品属性数据
     */
    public function includeAttributes(GoodsType $goodsType)
    {
        return $this->collection($goodsType->attributes, new AttributeTransformer());
    }

    /**
     * 加载商品规格数据
     */
    public function includeSpecs(GoodsType $goodsType)
    {
        return $this->collection($goodsType->specs, new SpecTransformer());
    }
}
