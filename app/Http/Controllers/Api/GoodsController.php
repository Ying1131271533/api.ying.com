<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use App\Models\GoodsType;
use App\Models\SpecItem;
use App\Services\Api\GoodsService;
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
        $satrt = microtime(true);
        // 分类数据
        $catgorys = cache_categorys();

        // 要注意每个搜索条件或者排序条件的先后顺序

        // 获取商品筛选数据
        $goodsAttrScreen = GoodsService::getGoodsAttrScreen($request->query());

        $params = [
            'title'       => $request->query('title'),
            'category_id' => $request->query('category_id', 0),
            'brand_id'    => $request->query('brand_id'),
            'attr'        => $request->query('attr'),
            'sort'        => $request->query('sort'),
            'price_range' => $request->query('price_range'),
            'limit'       => $request->query('limit', 10),
        ];

        // 获取商品列表
        $goods = GoodsService::getGoodsList($params);

        // 处理排序的url
        $sortArray = ['default', 'asc'];
        if (!empty($sortArray = explode('-', $params['sort']))) {
            $sortArray = explode('-', $params['sort']);
        }
        $sort = [
            'sales'          => '',
            'comments_count' => '',
            'new'            => '',
            'price'          => '',
            'default'        => '',
        ];
        // 组装
        foreach ($sort as $key => $value) {
            $temp         = $params;
            $temp['sort'] = "{$key}-" . ($sortArray[0] == $key) ? ($sortArray[1] == 'asc' ? 'desc' : 'asc') : 'asc';
            $sort[$key]   = url('api/goods', $temp);
        }

        // 推荐商品
        $recommend_goods = Goods::select('id', 'title', 'cover', 'shop_price')
            ->where(['is_on' => 1, 'is_recommend' => 1])
            ->withCount('comments')
            ->inRandomOrder()
            ->limit(10)
            ->get();
        $end = microtime(true);

        return $this->response->array([
            'end_time' => $end - $satrt,
            // 'categorys'       => $catgorys,
            // 'goodsAttrScreen' => $goodsAttrScreen,
            // 'goods'           => $goods,
            // 'goods'           => json_decode($this->response->paginator($goods, new GoodsTransformer)->morph()->getContent()),
            // 'recommend_goods' => $recommend_goods,
        ]);
    }

    /**
     * 商品详情
     */
    public function show($id)
    {
        // 详情
        $goods = Goods::with([
            'details',
            'attributes',
            'attributes.attribute' => function ($query) {
                $query->select('id', 'goods_type_id', 'name', 'input_type', 'values');
            },
            'specs',
            'specItemPics',
            'comments',
            'comments.user' => function ($query) {
                $query->select('id', 'name', 'avatar');
            }])
            ->find($id);

        // 获取商品规格需要显示的规格项
       $show_specs = GoodsService::getShowSpecs($goods->specs);

        // 相似的商品
        // 1 根据用户在那个商品上停留的时间 来给用户做推荐商品
        // 2 或者是哪一类的商品查看很多次
        $like_goods = Goods::where('is_on', 1)
            ->where('category_id', $goods['category_id'])
            ->limit(10)
            ->inRandomOrder() // 随机排序
            ->select('id', 'title', 'cover', 'shop_price', 'sales')
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
            'show_specs' => $show_specs,
            'like_goods' => $like_goods,
        ]);
    }
}
