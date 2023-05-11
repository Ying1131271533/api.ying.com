<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Node;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        return Node::where('parent_id', 0)->with('children.children')->get();
    }

    /**
     * 添加
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 详情
     */
    public function show($id)
    {
        //
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除
     */
    public function destroy($id)
    {
        //
    }
}
