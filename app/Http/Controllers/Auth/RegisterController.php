<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterController extends BaseController
{
    /**
     * 用户注册
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = new User();
        $result = $user->fill($data)->save();
        if(!$result) throw new HttpException(500, '注册失败！');
        return $this->response->created();
        // 返回token
        // $data['password'] = $request->validated()['password'];
        // $token = auth('api')->attempt($data);
        // return $this->respondWithToken($token);
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
