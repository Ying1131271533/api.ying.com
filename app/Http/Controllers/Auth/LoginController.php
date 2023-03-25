<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends BaseController
{
    /**
     * 登录
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (!$token = auth('api')->attempt($data)) {
            return $this->response->errorUnauthorized('账号或密码错误！');
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
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
