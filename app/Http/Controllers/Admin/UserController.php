<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 用户列表
     */
    public function index(Request $request)
    {
        $name  = $request->input('name');
        $email = $request->input('email');
        $limit = $request->input('limit', 2);
        $users = User::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })
        ->when('email', function ($query) use ($email) {
            $query->where('email', 'like', "%{$email}%");
        })
        ->paginate($limit);
        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * 用户详情
     */
    public function show(User $user)
    {
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * 用户 启用/禁用
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        if(!$user->save()) return $this->response->errorInternal('修改失败！');
        return $this->response->noContent();
    }
}
