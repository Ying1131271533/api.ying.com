<?php

namespace App\Http\Middleware;

use App\Http\Requests\UserRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckPhoneCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'phone' => 'required|regex:/^1[3-9]\d{9}$/',
            'code'  => 'required|digits:4',
        ], [
            'phone.required' => '电话不能为空',
            'phone.regex'    => '电话格式不正确',
            'phone.unique'   => '电话已被使用',
            'code.required'  => '验证码不能为空',
            'code.digits'    => '验证码必须是4位数字',
        ]);

        $phone = $request->input('phone');
        $code  = $request->input('code');

        // 验证code是否正确
        if (Cache::store('redis')->get('phone_code:' . $phone) != $code) {
            return abort(400, '验证码或手机号错误！');
        }

        return $next($request);
    }
}
