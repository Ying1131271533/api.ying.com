<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id'         => $category->id,
            'parent_id'  => $category->parent_id,
            'name'       => $category->name,
            'level'      => $category->level,
            'status'     => $category->status,
            'group'      => $category->group,
            'created_at' => $category->created_at->toDateTimeString(),
            'updated_at' => $category->updated_at->toDateTimeString(),
        ];
    }
}
