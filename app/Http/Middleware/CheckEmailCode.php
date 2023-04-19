<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckEmailCode
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
            'email' => 'required|email|unique:users,email',
            'code'  => 'required|digits:4',
        ], [
            'email.required' => '邮箱不能为空',
            'email.email'    => '邮箱格式不正确',
            'email.unique'   => '邮箱已被使用',
            'code.required'  => '验证码不能为空',
            'code.digits'    => '验证码必须是4位数字',
        ]);

        $email = $request->input('email');
        $code  = $request->input('code');

        // 验证code是否正确
        if (Cache::store('redis')->get('email_code:' . $email) != $code) {
            return abort(400, '验证码或邮箱错误！');
        }

        // 删除验证码缓存
        Cache::store('redis')->delete('email_code:' . $email);

        return $next($request);
    }
}
