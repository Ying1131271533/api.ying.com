<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 用户列表
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * 用户详情
     */
    public function show($id)
    {
        //
    }

    /**
     * 用户 启用/禁用
     */
    public function lock($id)
    {
        //
    }
}
