<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendMailCode;
use App\Events\SendSms;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use App\Mail\SendCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends BaseController
{
    public function __construct()
    {
        // 检查邮箱验证码
        $this->middleware(['check.email.code'])->only(['resetPasswordByEmail']);
        // 检查手机验证码
        $this->middleware(['check.phone.code'])->only(['resetPasswordBySms']);
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
    * 提交邮箱和验证码，修改密码
    */
   public function resetPasswordByEmail(UserRequest $request)
   {
       // 找到用户
       $user = User::where('email', $request->input('email'))->first();
       $user->password = bcrypt($request->input('password'));
       $user->save();

       // 删除验证码缓存
       Cache::store('redis')->delete('email_code:' . $request->input('email'));

       return $this->response->noContent();
   }

    /**
    * 发送手机验证码
    */
   public function smsCode(UserRequest $request)
   {
       $validated = $request->validated();
       // 生成验证码
       $code = make_code(4);
       // 发送验证码到手机
       SendSms::dispatch($validated['phone'], $code);
       return $this->response->noContent();
   }

   /**
    * 提交手机和验证码，修改密码
    */
   public function resetPasswordBySms(UserRequest $request)
   {
       // 找到用户
       $user = User::where('phone', $request->input('phone'))->first();
       $user->password = bcrypt($request->input('password'));
       $user->save();

       // 删除验证码缓存
       Cache::store('redis')->delete('phone_code:' . $request->input('phone'));

       return $this->response->noContent();
   }
}
