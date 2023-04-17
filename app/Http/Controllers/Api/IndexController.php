<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Good;
use App\Models\Slide;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 首页数据
     */
    public function index()
    {
        // 轮图数据
        $slides = Slide::where('status', 1)->orderBy('sort')->get();
        // 分类数据
        $categorys = cache_categorys();
        // 推荐商品
        $goods = Good::where('is_on', 1)->where('is_recommend', 1)->get();

        // 返回数据
        return $this->response->array([
            'slides' => $slides,
            'categorys' => $categorys,
            'goods' => $goods,
        ]);
    }
}
