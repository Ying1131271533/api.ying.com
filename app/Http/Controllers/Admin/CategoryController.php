<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Services\Admin\CategoryServices;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * 分类列表
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        if($type == 'all') return cache_categorys_all();
        return cache_categorys();
    }

    /**
     * 添加分类
     * 最大为三级
     */
    public function store(CategoryRequest $request)
    {
        // 获取验证参数
        $validated = $request->validated();
        CategoryServices::saveCategory($validated);
        return $this->response->created();
    }

    /**
     * 查看分类
     */
    public function show(Category $category)
    {
        return $this->response->item($category, new CategoryTransformer);
    }

    /**
     * 更新分类
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // 获取验证参数
        $validated = $request->validated();
        CategoryServices::saveCategory($validated, $category);
        return $this->response->noContent();
    }

    /**
     * 分类 启用/禁用
     */
    public function status(Category $category)
    {
        // 获取验证参数
        $category->status = $category->status == 1 ? 0 : 1;
        $result = $category->save();
        if(!$result) return $this->response->errorInternal('更改失败！');
        return $this->response->noContent();
    }
}
