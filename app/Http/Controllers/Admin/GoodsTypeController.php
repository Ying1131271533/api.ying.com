<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GoodsTypeRequest;
use App\Models\GoodsType;
use App\Transformers\GoodsTypeTransformer;
use Illuminate\Http\Request;

class GoodsTypeController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        // 条件参数
        $name = $request->query('name');
        $limit = $request->query('limit', 10);

        // 获取数据
        $goodsTypes = GoodsType::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })
        ->paginate($limit);
        return $this->response->paginator($goodsTypes, new GoodsTypeTransformer);
    }

    /**
     * 添加
     */
    public function store(GoodsTypeRequest $request)
    {
        // 获取验证数据
        $validated = $request->validated();
        // 保存数据
        $result = GoodsType::create($validated);
        if(!$result) return $this->response->errorInternal();
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(GoodsType $goods_type)
    {
        return $this->response->item($goods_type, new GoodsTypeTransformer);
    }

    /**
     * 更新
     */
    public function update(GoodsTypeRequest $request, GoodsType $goods_type)
    {
        // 验证数据
        $validated = $request->validated();
        $result = $goods_type->update($validated);
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 状态
     */
    public function isIndex(GoodsType $goods_type)
    {
        $goods_type->status = $goods_type->status == 0 ? 1 : 0;
        $result = $goods_type->save();
        if(!$result) return $this->response->errorInternal('操作失败！');
        return $this->response->noContent();
    }
}
