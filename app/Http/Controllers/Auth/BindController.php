<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BindController extends BaseController
{
    /**
     * 发送邮件的验证码
     */
    public function emailCode(UserRequest $request)
    {
        $validated = $request->validated();

        // 发送验证码到邮箱
        // Mail::to($validated['email'])->send(new SendCode($validated['email']));
        Mail::to($validated['email'])->queue(new SendCode($validated['email']));

        return $this->response->noContent();
    }

    /**
     * 修改邮箱
     */
    public function updateEmail(UserRequest $request)
    {
        $validated = $request->validated();
        // 验证code是否正确
        if(!Cache::store('redis')->has('email_code:' . $validated['email'])) {
            return $this->response->errorBadRequest('验证码或邮箱错误！');
        }

        // 更新邮箱
        $user = auth('api')->user();
        $user->email = $validated['email'];
        $user->save();

        return $this->response->noContent();
    }
}
