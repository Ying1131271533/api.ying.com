<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use App\Transformers\AdminTransformer;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public function __construct()
    {
        // 如果路由那边出现问题就用这里
        // $this->middleware('auth.admin');
    }

    public function test()
    {
        return auth('admin')->user();
    }

    /**
     * 列表
     */
    public function index(Request $request)
    {
        $roles = Admin::paginate(20);
        return $this->response->paginator($roles, new AdminTransformer);
    }

    /**
     * 添加
     */
    public function store(AdminRequest $request)
    {
        $validetad = $request->validated();
        AdminService::saveAdmin($validetad);
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Admin $admin)
    {
        return $this->response->item($admin, new AdminTransformer);
    }

    /**
     * 更新
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $validetad = $request->validated();
        AdminService::saveAdmin($validetad, $admin);
        return $this->response->noContent();
    }

    /**
     * 删除
     */
    public function destroy(Admin $admin)
    {
        //
    }

    /**
     * 启用/禁用
     */
    public function lock(Admin $admin)
    {
        $admin->is_locked == 1 ? 0 : 1;
        if(!$admin->save()) return $this->response->errorInternal('修改失败！');
        return $this->response->noContent();
    }

    /**
     * 获取管理员信息
     */
    public function info()
    {
        return $this->response->item(auth('admin')->user(), new AdminTransformer);
    }

    /**
     * 根据管理员id获取管理员信息
     */
    public function getAdminById(Admin $admin)
    {
        return $this->response->array(['id' => $admin->id, 'name' => $admin->name]);
    }


}
