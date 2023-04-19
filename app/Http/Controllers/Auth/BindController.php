<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendSms;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use App\Mail\SendCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Overtrue\EasySms\EasySms;

class BindController extends BaseController
{
    public function __construct()
    {
        // 检查手机验证码
        $this->middleware(['check.email.code'])->only(['updateEmail']);
        $this->middleware(['check.phone.code'])->only(['updatePhone']);
    }

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
    public function updateEmail(Request $request)
    {
        // 更新邮箱
        $user = auth('api')->user();
        $user->email = $request->input('email');
        $user->save();

        // 删除验证码缓存
        Cache::store('redis')->delete('email_code:' . $request->input('email'));

        return $this->response->noContent();
    }

    /**
     * 发送手机的验证码
     */
    public function phoneCode(UserRequest $request)
    {
        $validated = $request->validated();

        // 发送短信事件
        SendSms::dispatch($validated['phone']);
        // SendSms::dispatch($validated['phone'], '绑定手机');

        return $this->response->noContent();
    }

    /**
     * 修改手机号
     */
    public function updatePhone(Request $request)
    {
        // 更新手机号
        $user = auth('api')->user();
        $user->phone = $request->input('phone');
        $user->save();

        return $this->response->noContent();
    }
}
