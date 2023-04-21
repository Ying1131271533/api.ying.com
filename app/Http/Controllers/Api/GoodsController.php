<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Good;
use App\Transformers\GoodsTransformer;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index(Request $request)
    {
        // 分类数据
        $catgorys = cache_categorys();

        // 商品的分页数据
        $goods = Good::select('id', 'title', 'cover', 'price')
        ->where('is_on', 1)
        ->withCount('comments')
        ->paginate(20);

        // 推荐商品
        $recommend_goods = Good::select('id', 'title', 'cover', 'price')
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
        $goods = Good::where('id', $id)
        ->with(['comments', 'comments.user' => function ($query) {
            $query->select('id', 'name', 'avatar');
        }])
            ->first($id)
            ->append('pics_url');
        // $goods = Good::where('id', $id)->first();

        // 相似的商品
        // 1 根据用户在那个商品上停留的时间 来给用户做只能推荐商品
        // 2 或者是哪一类的商品查看很多次
        $like_goods = Good::where('is_on', 1)
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
