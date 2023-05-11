<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\LoginRequest;

class AuthController extends BaseController
{
    /**
     * 登录
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        // 获取账号类型 邮箱/手机
        $type = filter_var($validated['account'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'phone';
        $data = [$type => $validated['account'], 'password' => $validated['password']];
        // 验证账号
        if (!$token = auth('admin')->attempt($data)) {
            return $this->response->errorUnauthorized('账号或密码错误！');
        }

        // 检查用户状态
        if(auth('admin')->user()->is_locked == 1) {
            return $this->response->errorForbidden('管理员被禁止使用！');
        }

        return $this->respondWithToken($token);
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
