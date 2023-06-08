<?php

namespace App\Transformers;

use App\Models\Spec;
use League\Fractal\TransformerAbstract;

class SpecTransformer extends TransformerAbstract
{
    public function transform(Spec $spec)
    {
        // 可include的模型
        $this->setAvailableIncludes(['goodsType', 'items']);

        return [
            'id'              => $spec->id,
            'goods_type_id'   => $spec->goods_type_id,
            'name'            => $spec->name,
            'is_index'        => $spec->is_index,
            'sort'            => $spec->sort,
            'created_at'      => $spec->created_at,
            'updated_at'      => $spec->updated_at,
        ];
    }

    /**
     * 加载商品类型数据
     */
    public function includeGoodsType(Spec $spec)
    {
        return $this->item($spec->goodsType, new GoodsTypeTransformer());
    }

    /**
     * 加载商品规格的规格项数据
     */
    public function includeItems(Spec $spec)
    {
        return $this->collection($spec->items, new SpecItemTransformer());
    }
}
