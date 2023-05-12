<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\RoleRequest;
use App\Transformers\RoleTransformer;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        $roles = Role::paginate(20);
        return $this->response->paginator($roles, new RoleTransformer);
    }

    /**
     * 添加
     */
    public function store(RoleRequest $request)
    {
        $validated = $request->validated();
        $validated['guard_name'] = 'admin';
        Role::create($validated);
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * 更新
     */
    public function update(RoleRequest $request, Role $role)
    {
        //
    }

    /**
     * 删除
     */
    public function destroy(Role $role)
    {

    }

    /**
     * 获取角色拥有的权限
     */
    public function getPermissions(RoleRequest $request, Role $role)
    {
        //
    }

    /**
     * 角色获取权限
     */
    public function grantPermissions(RoleRequest $request, Role $role)
    {
        //
    }
}
