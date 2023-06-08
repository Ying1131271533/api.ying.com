<?php

namespace App\Transformers;

use App\Models\SpecItem;
use League\Fractal\TransformerAbstract;

class SpecItemTransformer extends TransformerAbstract
{
    public function transform(SpecItem $specItem)
    {
        // 可include的模型
        $this->setAvailableIncludes(['specItems']);

        return [
            'id'         => $specItem->id,
            'spec_id'   => $specItem->spec_id,
            'name'       => $specItem->name,
        ];
    }

    /**
     * 加载商品规格数据
     */
    public function includeItems(SpecItem $specItem)
    {
        return $this->collection($specItem->items, new SpecTransformer());
    }
}
