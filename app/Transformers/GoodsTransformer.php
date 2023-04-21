<?php

namespace App\Transformers;

use App\Models\Good;
use League\Fractal\TransformerAbstract;

class GoodsTransformer extends TransformerAbstract
{
    // 加载分类数据
    // protected $availableIncludes = ['category']; // 不能用？！好吧，那就用下面那两种吧

    public function transform(Good $good)
    {
        // 设置关联分类模型
        // 单个访问地址：goods?include=category
        // $this->availableIncludes = ['category'];

        // 设置关联分类、用户模型
        // 多个访问地址方式1：goods?include=category,user
        // 多个访问地址方式2：goods?include[]=category&include[]=user
        $this->setAvailableIncludes(['category', 'user', 'comments']);

        $pics_url = [];
        foreach ($good->pics as $pic) {
            $pics_url[] = oss_url($pic);
        }

        return [
            'id'           => $good->id,
            'user_id'      => $good->user_id,
            // 'user_name'      => $good->user->user_name, // 用户模型关联
            'category_id'  => $good->category_id,
            // 'category_name' => $good->category->name, // 分类模型关联
            'title'        => $good->title,
            'description'  => $good->description,
            // 'price'        => number_format($good->price, 2, '.', ''), // 两位小数
            'price'        => $good->price,
            'stock'        => $good->stock,
            'cover'        => $good->cover,
            'cover_url'    => oss_url($good->cover),
            'pics'         => $good->pics,
            'pics_url'     => $pics_url,
            'is_on'        => $good->is_on,
            'is_recommend' => $good->is_recommend,
            'details'      => $good->details,
            'created_at'   => $good->created_at,
            'updated_at'   => $good->updated_at,
        ];
    }

    /**
     * 加载分类数据
     */
    public function includeCategory(Good $good)
    {
        return $this->item($good->category, new CategoryTransformer());
    }

    /**
     * 加载用户数据
     */
    public function includeUser(Good $good)
    {
        return $this->item($good->user, new UserTransformer());
    }

    /**
     * 加载评论数据
     */
    public function includeComments(Good $good)
    {
        return $this->collection($good->comments, new CommentTransformer());
    }
}
