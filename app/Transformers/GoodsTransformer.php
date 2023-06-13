<?php

namespace App\Transformers;

use App\Models\Goods;
use League\Fractal\TransformerAbstract;

class GoodsTransformer extends TransformerAbstract
{
    // 加载分类数据
    // protected $availableIncludes = ['category']; // 不能用？！好吧，那就用下面那两种吧

    public function transform(Goods $goods)
    {
        // 设置关联分类模型
        // 单个访问地址：goods?include=category
        // $this->availableIncludes = ['category'];

        // 设置关联分类、用户模型
        // 多个访问地址方式1：goods?include=category,admin
        // 多个访问地址方式2：goods?include[]=category&include[]=admin
        $this->setAvailableIncludes([
            // 'admin',
            // 'category',
            // 'brand',
            // 'goodsType',
            'details',
            'goodsAttributes',
            'goodsSpecs',
            'specItmePics',
            'comments',
        ]);

        return [
            'id'            => $goods->id,
            'admin_id'      => $goods->admin_id,
            'category_id'   => $goods->category_id,
            // 'category_name' => $goods->category->name, // 分类模型关联
            'brand_id'      => $goods->brand_id,
            'goods_type_id' => $goods->goods_type_id,
            'title'         => $goods->title,
            'cover'         => $goods->cover,
            'cover_url'         => $goods->cover_url,
            'shop_price'    => $goods->shop_price,
            'stock'         => $goods->stock,
            'sales'         => $goods->sales,
            'is_on'         => $goods->is_on,
            'is_recommend'  => $goods->is_recommend,
            'created_at'    => $goods->created_at,
            'updated_at'    => $goods->updated_at,
        ];
    }

    /**
     * 加载创建商品的管理员数据
     */
    public function includeAdmin(Goods $goods)
    {
        return $this->item($goods->admin, new UserTransformer());
    }

    /**
     * 加载分类数据
     */
    public function includeCategory(Goods $goods)
    {
        return $this->item($goods->category, new CategoryTransformer());
    }

    /**
     * 加载品牌数据
     */
    public function includeBrand(Goods $goods)
    {
        return $this->item($goods->brand, new BrandTransformer());
    }

    /**
     * 加载商品类型数据
     */
    public function includeGoodsType(Goods $goods)
    {
        return $this->item($goods->goodsType, new GoodsTypeTransformer());
    }

    /**
     * 加载商品详情数据
     */
    public function includeDetails(Goods $goods)
    {
        return $this->item($goods->details, new GoodsDetailsTransformer());
    }

    /**
     * 加载商品属性数据
     */
    public function includeGoodsAttributes(Goods $goods)
    {
        return $this->collection($goods->attributes, new GoodsAttributeTransformer());
    }


    /**
     * 加载商品规格套餐数据
     */
    public function includeGoodsSpecs(Goods $goods)
    {
        return $this->collection($goods->specs, new GoodsSpecTransformer());
    }

    /**
     * 加载商品规格项的图片数据
     */
    public function includeSpecItmePics(Goods $goods)
    {
        return $this->collection($goods->specItemPics, new GoodsSpecItemPicTransformer());
    }

    /**
     * 加载评论数据
     */
    public function includeComments(Goods $goods)
    {
        return $this->collection($goods->comments, new CommentTransformer());
    }
}
