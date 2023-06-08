<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AttributeReuqest;
use App\Models\Attribute;
use App\Transformers\AttributeTransformer;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        // 条件参数
        $include = $request->query('include');
        $name = $request->query('name');
        $limit = $request->query('limit', 10);

        // 获取数据
        $attributes = Attribute::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })
        ->paginate($limit)
        ->appends([
            'include' => $include,
            'name' => $name,
            'limit' => $limit,
        ]);
        return $this->response->paginator($attributes, new AttributeTransformer);
    }

    /**
     * 添加
     */
    public function store(AttributeReuqest $request)
    {
        // 获取验证数据
        $validated = $request->validated();
        $result = Attribute::create($validated);
        if(!$result) return $this->response->errorInternal();
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Attribute $attribute)
    {
        return $this->response->item($attribute, new AttributeTransformer);
    }

    /**
     * 更新
     */
    public function update(AttributeReuqest $request, Attribute $attribute)
    {
        // 获取验证数据
        $validated = $request->validated();
        $result = $attribute->update($validated);
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 检索
     */
    public function isIndex(Attribute $attribute)
    {
        $attribute->is_index = $attribute->is_index == 0 ? 1 : 0;
        $result = $attribute->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 排序
     */
    public function sort(AttributeReuqest $request, Attribute $attribute)
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
