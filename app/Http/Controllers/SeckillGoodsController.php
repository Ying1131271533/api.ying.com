<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Services\Lib\RedisLock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class SeckillGoodsController extends BaseController
{
    // Lua脚本
    public function index(Request $request)
    {
        Redis::set('akali', 100);return 1;

        // 秒杀商品库存key
        $stockKey = "seckill_goods_key:1:stock";
        // 秒杀成功用户key
        $userIdKey = "seckill_goods_key:1:user";

        // 实例化redisLock
        $redisLock = new RedisLock();
        if ($redisLock->lockByLua()) {

            // 逻辑代码
            $akali = Redis::get('akali');
            if ($akali > 0) {
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

    // Laravel自带的原子锁
    public function akali()
    {
        Cache::store('redis')->set('akali', 100);return 1;
        $lock = Cache::store('redis')->lock('foo', 10); // 锁定10秒
        if ($lock->get()) {

            // 逻辑代码
            $akali = Cache::store('redis')->get('akali');
            if ($akali > 0) {
                // 自减一
                Cache::store('redis')->decrement('akali');
            }

            // 释放锁
            $lock->release();
        }

    }

}
