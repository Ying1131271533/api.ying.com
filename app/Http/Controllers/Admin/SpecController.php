<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SpecRequest;
use App\Models\Spec;
use Illuminate\Http\Request;

class SpecController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * 添加
     */
    public function store(SpecRequest $request)
    {
        // 验证数据
        $validated = $request->validated();
        return $validated;
    }

    /**
     * 详情
     */
    public function show(Spec $spec)
    {
        //
    }

    /**
     * 更新
     */
    public function update(SpecRequest $request, Spec $spec)
    {
        //
    }

    /**
     * 检索
     */
    public function isIndex(Spec $attribute)
    {
        $attribute->is_index = $attribute->is_index == 0 ? 1 : 0;
        $result = $attribute->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 排序
     */
    public function sort(SpecRequest $request, Spec $attribute)
    {
        // 验证的数据
        $validated = $request->validated();
        // 更新数据
        $attribute->sort = $validated['sort'];
        $result = $attribute->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }
}
