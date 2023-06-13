<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Brand;
use App\Models\Goods;
use App\Transformers\GoodsTransformer;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index(Request $request)
    {
        // 分类数据
        $catgorys = cache_categorys();
        // 要注意每个搜索条件或者排序条件的先后顺序

        // 搜索条件
        $title       = $request->query('title');
        $category_id = $request->query('category_id');
        $brand_id = $request->query('brand_id');

        // 排序
        $sales          = $request->query('sales');
        $price          = $request->query('price');
        $comments_count = $request->query('comments_count');

        // 商品的分页数据
        $goodsQuery = Goods::select('id', 'category_id', 'brand_id', 'title', 'cover', 'market_price', 'shop_price', 'stock', 'sales')
            ->where('is_on', 1)
            ->when($title, function ($query) use ($title) {
                $query->where('title', 'like', "%{$title}%");
            })
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })
            ->when($brand_id, function ($query) use ($brand_id) {
                $query->where('brand_id', $brand_id);
            });

            // 老师：正常的排序没有这么简单，而是使用了复杂的算法
        $goods = $goodsQuery->when($sales == 1, function ($query) {
                $query->orderBy('sales', 'desc');
            })
            ->when($price == 1, function ($query) {
                $query->orderBy('shop_price', 'desc');
            })
            ->when($comments_count == 1, function ($query) {
                $query->orderBy('comments_count', 'desc');
            })
            ->withCount('comments')
            ->orderBy('updated_at', 'desc')
            ->simplePaginate(20);

        // 品牌
        // $goods_brand_ids = $goodsQuery->distinct()->pluck('brand_id');
        // return $goods_brand_ids;

        // 推荐商品
        $recommend_goods = Goods::select('id', 'title', 'cover', 'shop_price')
            ->where(['is_on' => 1, 'is_recommend' => 1])
            ->withCount('comments')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return $this->response->array([
            'categorys'       => $catgorys,
            'goods'           => $goods,
            // 'goods'           => json_decode($this->response->paginator($goods, new GoodsTransformer)->morph()->getContent()),
            'recommend_goods' => $recommend_goods,
        ]);
    }

    /**
     * 商品详情
     */
    public function show($id)
    {
        // 详情
        $goods = Goods::query()->where('id', $id)
            ->with(['comments', 'comments.user' => function ($query) {
                $query->select('id', 'name', 'avatar');
            }])
            ->first()
            ->append('pics_url');

        // 相似的商品
        // 1 根据用户在那个商品上停留的时间 来给用户做只能推荐商品
        // 2 或者是哪一类的商品查看很多次
        $like_goods = Goods::where('is_on', 1)
            ->where('category_id', $goods['category_id'])
            ->limit(10)
            ->inRandomOrder() // 随机排序
            ->select('id', 'title', 'cover', 'price', 'sales')
            ->get();
        // 单个隐藏
        // ->transform(function ($item) {
        //     // 隐藏price字段
        //     // 因为没有获取pics字段，那么访问器那边也会获取不到，然后返回空数据
        //     return $item->setHidden(['pics_url']);
        // });
        // 所有
        // ->makeHidden('pics_url');
        // 追加 pics_url 字段

        // 返回数据
        return $this->response->array([
            'goods'      => $goods,
            'like_goods' => $like_goods,
        ]);
    }

}
