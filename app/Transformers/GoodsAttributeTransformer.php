<?php

namespace App\Transformers;

use App\Models\GoodsAttribute;
use League\Fractal\TransformerAbstract;

class GoodsAttributeTransformer extends TransformerAbstract
{
    public function transform(GoodsAttribute $goodsAttribute)
    {
        // 可include的模型
        $this->setAvailableIncludes(['attribute']);
        return [
            'goods_id'       => $goodsAttribute->goods_id,
            'attribute_id'   => $goodsAttribute->attribute_id,
            'value'          => $goodsAttribute->value,
            'created_at'     => $goodsAttribute->created_at,
            'updated_at'     => $goodsAttribute->updated_at,
        ];
    }

    /**
     * 加载商品类型数据
     */
    public function includeAttribute(GoodsAttribute $goodsAttribute)
    {
        return $this->item($goodsAttribute->attribute, new AttributeTransformer());
    }
}
