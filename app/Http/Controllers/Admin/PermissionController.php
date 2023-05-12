<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\Node;
use App\Services\Admin\PermissionService;
use App\Transformers\PermissionTransformer;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

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
    public function store(PermissionRequest $request)
    {
        $validated = $request->validated();
        PermissionService::savePermission($validated);
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Permission $permission)
    {
        return $this->response->item($permission, new PermissionTransformer);
    }

    /**
     * 更新
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $validated = $request->validated();
        $permission->fill($validated)->save();
        return $this->response->noContent();
    }

    /**
     * 删除
     */
    public function destroy(Permission $permission)
    {
        try {
            DB::beginTransaction();
            // 获取拥有节点权限的角色
            $roles = $permission->roles;
            // 从角色中删除权限
            foreach ($roles as $role) {
                $role->revokePermissionTo($permission->name);
            }
            // 删除节点
            $permission->delete();
            DB::commit();
            return $this->response->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
