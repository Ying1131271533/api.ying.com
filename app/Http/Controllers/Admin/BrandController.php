<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Transformers\BrandTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        // 条件参数
        $name = $request->query('name');
        $status = $request->query('status');
        $limit = $request->query('limit', 10);

        // 获取数据
        $brands = Brand::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($limit);
        // return $this->response->paginator($brands, new BrandTransformer);

        // layui
        return layui([
            'data' => $brands->toArray()['data'],
            'total' => $brands->toArray()['total'],
        ]);
    }

    /**
     * 添加
     */
    public function store(BrandRequest $request)
    {
        // 验证的数据
        $validated = $request->validated();
        // 保存
        $result = Brand::create($validated);
        if(!$result) return $this->response->errorInternal('添加失败！');
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Brand $brand)
    {
        return $this->response->item($brand, new BrandTransformer);
    }

    /**
     * 更新
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        // 验证的数据
        $validated = $request->validated();
        // 获取旧logo
        $old_logo = $brand->logo;

        // 更新
        $result = $brand->update($validated);
        if(!$result) return $this->response->errorInternal('更新失败！');

        // 删除旧logo
        delete_old_file($validated['logo'], $old_logo);

        return $this->response->noContent();
    }

    /**
     * 排序
     */
    public function sort(BrandRequest $request, Brand $brand)
    {
        // 验证的数据
        $validated = $request->validated();
        // 更新数据
        $brand->sort = $validated['sort'];
        $result = $brand->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 状态
     */
    public function status(Brand $brand)
    {
        $brand->status = $brand->status == 0 ? 1 : 0;
        $result = $brand->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }
}
