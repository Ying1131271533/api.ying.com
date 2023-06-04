<?php

namespace App\Transformers;

use App\Models\Brand;
use League\Fractal\TransformerAbstract;

class BrandTransformer extends TransformerAbstract
{
    public function transform(Brand $brand)
    {
        return [
            'id'         => $brand->id,
            'name'       => $brand->name,
            'logo'       => $brand->logo,
            'sort'       => $brand->sort,
            'status'     => $brand->status,
            'created_at' => $brand->created_at,
            'updated_at' => $brand->updated_at,
        ];
    }
}
