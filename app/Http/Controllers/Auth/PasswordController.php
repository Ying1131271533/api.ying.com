<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;

class PasswordController extends BaseController
{
    public function updatePassword(UserRequest $request)
    {
        // 验证密码
        // if(password_verify($validated['password'], $user->password));
        $validated = $request->validated();
        $user = auth('api')->user();
        $user->password = bcrypt($validated['password']);
        $user->save();
        return $this->response->noContent();
    }
}
