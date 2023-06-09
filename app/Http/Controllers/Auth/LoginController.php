<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
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
        if (!$token = auth('api')->attempt($data)) {
            return $this->response->errorUnauthorized('账号或密码错误！');
        }

        // 检查用户状态
        if(auth('api')->user()->is_locked == 1) {
            return $this->response->errorForbidden('用户被禁止使用！');
        }

        return $this->respondWithToken($token);
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->response->noContent();
    }

    /**
     * 刷新token  一般由前端来判断token是否快过期了 然后重新获取token
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
            'expires_in' => auth('api')->factory()->getTTL() * env('JWT_TTL')
        ]);
    }
}
