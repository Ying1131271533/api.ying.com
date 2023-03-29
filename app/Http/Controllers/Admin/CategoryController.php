<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

class CategoryController extends BaseController
{
    /**
     * 分类列表
     */
    public function index()
    {
        return categoryTree();
    }

    /**
     * 添加分类
     * 最大为三级
     */
    public function store(CategoryRequest $request)
    {
        // 获取验证参数
        $validated = $request->validated();

        // 获取父级id
        $parent_id = $validated['parent_id'];

        // 计算等级
        $validated['level'] = $parent_id == 0 ? 1 : Category::find($parent_id)->level + 1;

        // 分类不能超过3级
        if($validated['level'] > 3) return $this->response->errorBadRequest('等级不能大于3级');

        // 插入数据
        $category = Category::create($validated);
        if(!$category) return $this->response->errorForbidden('保存失败！');
        return $this->response->created();
    }

    /**
     * 查看分类
     */
    public function show($id)
    {
        //
    }

    /**
     * 更新分类
     */
    public function update(CategoryRequest $request, $id)
    {
        //
    }
}
