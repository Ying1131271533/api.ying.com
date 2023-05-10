<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    /**
     * 添加管理员
     */
    public function store(AdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = new Admin();
        $result = $user->fill($data)->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->created();
    }

    /**
     * 格式化返回
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60
        ]);
    }
}
