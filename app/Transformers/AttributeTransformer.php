<?php

namespace App\Transformers;

use App\Models\Attribute;
use App\Models\GoodsType;
use League\Fractal\TransformerAbstract;

class AttributeTransformer extends TransformerAbstract
{
    public function transform(Attribute $attribute)
    {
        // 可include的模型
        $this->setAvailableIncludes(['goodsType']);

        return [
            'id'              => $attribute->id,
            'goods_type_id'   => $attribute->goods_type_id,
            'name'            => $attribute->name,
            'is_index'        => $attribute->is_index,
            'input_type'      => $attribute->input_type,
            'input_type_name' => $attribute->input_type_name,
            'values'          => $attribute->values,
            'sort'            => $attribute->sort,
            'created_at'      => $attribute->created_at,
            'updated_at'      => $attribute->updated_at,
        ];
    }

    /**
     * 加载商品类型数据
     */
    public function includeGoodsType(Attribute $attribute)
    {
        return $this->item($attribute->goodsType, new GoodsTypeTransformer());
    }
}
