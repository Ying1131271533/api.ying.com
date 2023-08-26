<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SetBearerToRequestHeader
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
        // $data = [$type => $validated['account'], 'password' => $validated['password']];
        // // 验证账号
        // if (!$token = auth('api')->attempt($data)) {
        //     return $this->response->errorUnauthorized('账号或密码错误！');
        // }
        // Log::info('id', ['token' => $request->get('token')]);
        $request->headers->set('Authorization', 'Bearer ' . $request->get('token'));
        return $next($request);
    }
}
