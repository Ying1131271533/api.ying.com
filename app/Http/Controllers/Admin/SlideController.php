<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;
use App\Transformers\SlideTransformer;
use Illuminate\Http\Request;

class SlideController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $limit = $request->query('limit', 10);
        $slides = Slide::when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($limit);
        return $this->response->paginator($slides, new SlideTransformer);
    }

    /**
     * 添加
     */
    public function store(SlideRequest $request)
    {
        $validated = $request->validated();
        // $validated['sort'] = Slide::max('sort') ?? 1;
        $validated['sort'] = Slide::max('sort') ? Slide::max('sort') + 1 : 1;
        $slide = Slide::create($validated);
        if(!$slide) return $this->response->errorInternal('添加失败！');
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Slide $slide)
    {
        return $this->response->item($slide, new SlideTransformer);
    }

    /**
     * 更新
     */
    public function update(SlideRequest $request, Slide $slide)
    {
        $validated = $request->validated();
        $result = $slide->fill($validated)->save();
        if(!$result) return $this->response->errorInternal('更新失败！');
        return $this->response->noContent();
    }

    /**
     * 删除
     */
    public function destroy(Slide $slide)
    {
        $result = $slide->delete();
        if(!$result) return $this->response->errorInternal('删除失败！');
        return $this->response->noContent();
    }

    /**
     * 排序
     */
    public function sort(SlideRequest $request, Slide $slide)
    {
        $validated = $request->validated();
        $result = $slide->fill($validated)->save();
        if(!$result) return $this->response->errorInternal('排序失败！');
        return $this->response->noContent();
    }

    /**
     * 状态
     */
    public function status(Slide $slide)
    {
        $slide->status = $slide->status == 0 ? 1 :0;
        $result = $slide->save();
        if(!$result) return $this->response->errorInternal('改变失败！');
        return $this->response->noContent();
    }
}
