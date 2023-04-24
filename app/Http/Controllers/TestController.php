<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Services\Lib\RedisLock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TestController extends BaseController
{
    public function index(Request $request)
    {
        Redis::set('akali', 100);return 1;
        // 实例化redisLock
        $redisLock = new RedisLock();
        if ($redisLock->lockByLua()) {

            // 逻辑代码
            $akali = Redis::get('akali');
            if($akali > 0) {
                Redis::decr('akali');
            }

            // 释放锁
            $result = $redisLock->unlock();
            if (!$result) {
                return $this->response->errorBadRequest('抢购失败');
            }
        } else {
            return $this->response->errorBadRequest('抢购失败');
        }
        return $this->response->noContent();
    }

}
