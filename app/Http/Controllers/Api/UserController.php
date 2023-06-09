<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;

class UserController extends BaseController
{
    /**
     * 用户个人信息详情
     */
    public function userInfo()
    {
        return $this->response->item(auth('api')->user(), new UserTransformer);
    }

    /**
     * 更新用户个人信息
     */
    public function updateUserInfo(UserRequest $reuqest)
    {
        $validated = $reuqest->validated();
        $user = auth('api')->user();
        $user->fill($validated)->save();
        return $this->response->noContent();
    }

    /**
     * 更新用户头像
     */
    public function updateUserAvatar(UserRequest $reuqest)
    {
        $validated = $reuqest->validated();
        $user = auth('api')->user();
        $user->fill($validated)->save();
        return $this->response->noContent();
    }
    /**
     * 用户个人信息详情
     */
    public function getUserById(User $user)
    {
        return $this->response->item($user, new UserTransformer);
    }

}
