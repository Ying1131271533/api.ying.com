<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendMailCode;
use App\Events\SendSms;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use App\Mail\SendCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
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

        // 生成验证码
        $code = make_code(4);
       // 发送验证码到邮箱
       SendMailCode::dispatch($validated['email'], $code);

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
        $phone     = $validated['phone'];

        // 验证码
        $code = make_code(4);

        // 发送短信事件
        SendSms::dispatch($phone, $code);
        // SendSms::dispatch($phone, $code, '绑定手机');

        return $this->response->noContent();
    }

    /**
     * 修改手机号
     */
    public function updatePhone(Request $request)
    {
        $user = auth('api')->user();
        $user->phone = $request->input('phone');
        $user->save();

        // 删除验证码缓存
        Cache::store('redis')->delete('phone_code:' . $request->input('phone'));

        return $this->response->noContent();
    }
}
