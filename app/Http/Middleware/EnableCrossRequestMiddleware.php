<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnableCrossRequestMiddleware
{
    /**
     * 跨域解决方案
     *
     * 等等？postman可以设置头部为 http://api.ying.com 来访问接口，那还有用吗？
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        // dd($origin);
        // 允许访问
        $allow_origin = [
            'http://www.ying.com',
            // 浏览器访问时，二级域名为: api 的不行
            // postman设置头部信息 Origin 为: http://api.ying.com 可以访问
            'http://api.ying.com',
            'http://m.ying.com',
            'http://www.wse.com',
        ];

        if (!in_array($origin, $allow_origin)) {
            return abort(400, '禁止访问！');
        }

        $response->header('Access-Control-Allow-Origin', $origin);
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, X-XSRF-TOKEN, Authorization');
        $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, DEAD, OPTIONS');
        $response->header('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
