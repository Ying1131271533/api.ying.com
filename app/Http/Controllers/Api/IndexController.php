<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Goods;
use App\Models\Slide;
use App\Transformers\GoodsTransformer;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 首页数据
     */
    public function index()
    {
        // 轮播图数据
        $slides = Slide::where('status', 1)->orderBy('sort')->get();
        // 分类数据
        $categorys = cache_categorys();
        // 推荐商品
        $goods = Goods::where('is_on', 1)->where('is_recommend', 1)->limit(20)->get();

        // 返回数据
        return $this->response->array([
            'slides'    => $slides,
            'categorys' => $categorys,
            'goods'     => $goods,
            // 不推荐使用
            // 'goods'     => json_decode($this->response->collection($goods, new GoodsTransformer)->morph()->getContent(), true),
        ]);
    }
}
