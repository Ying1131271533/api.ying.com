<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GoodsRequest;
use App\Http\Services\Admin\GoodsServices;
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
        $title        = $request->query('title');
        $category_id  = $request->query('category_id');
        $is_on        = $request->query('is_on', false);
        $is_recommend = $request->query('is_recommend', false);

        $goods = Good::when($title, function ($query) use ($title) {
            $query->where('title', 'like', "%{$title}%");
        })
        ->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
        ->when($is_on !== false, function ($query) use ($is_on) {
            $query->where('is_on', $is_on);
        })
        ->when($is_recommend !== false, function ($query) use ($is_recommend) {
            $query->where('is_recommend', $is_recommend);
        })
        ->paginate(2);

        return $this->response->paginator($goods, new GoodsTransformer);
    }

    /**
     * 商品添加
     */
    public function store(GoodsRequest $request)
    {
        $validated = $request->validated();
        GoodsServices::saveGoods($validated);
        return $this->response->created();
    }

    /**
     * 商品详情
     */
    public function show(Good $good)
    {
        return $this->response->item($good, new GoodsTransformer);
    }

    /**
     * 商品更新
     */
    public function update(GoodsRequest $request, Good $good)
    {
        $validated = $request->validated();
        GoodsServices::saveGoods($validated, $good);
        return $this->response->noContent();
    }

    /**
     * 商品上架
     */
    public function isOn(Good $good)
    {
        $good->is_on = $good->is_on == 1 ? 0 : 1;
        $result = $good->save();
        if(!$result) return $this->response->errorInternal('操作失败！');
        return $this->response->noContent();
    }

    /**
     * 商品推荐
     */
    public function isRecommend(Good $good)
    {
        $good->is_recommend = $good->is_recommend == 1 ? 0 : 1;
        $result = $good->save();
        if(!$result) return $this->response->errorInternal('操作失败！');
        return $this->response->noContent();
    }
}