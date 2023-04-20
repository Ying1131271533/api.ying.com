<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class TestController extends BaseController
{
    protected $_lockFlag;
    public function index(Request $request)
    {
        Cache::store('redis')->set('akali', 100);return 1;
        $lock = Cache::store('redis')->lock('foo', 10); // 锁定10秒
        if ($lock->get()) {

            // 逻辑代码
            $akali = Cache::store('redis')->get('akali');
            if($akali > 0) {
                Cache::store('redis')->decrement('akali');
            }
            // 释放锁
            $lock->release();
        }
        return 1;
        if ($this->lock()) {
            // 下面是...业务代码
        }else{
            throw new BadRequestException('抢购失败');
        }

        return ['name' => '阿卡丽'];
    }


    function lock($key = 'lock', $expire = 5)
    {


        // 秒杀商品库存key
        $stockKey = "seckill_goods_key:1:stock";
        // 秒杀成功用户key
        $userIdKey = "seckill_goods_key:1:user";

        // 锁标识
        $this->_lockFlag = md5(microtime(true));

        $result = Redis::eval(<<<EOF

        local key = KEYS[1]
        local value = KEYS[2]
        local ttl = KEYS[3]

        if (redis.call('setnx', key, value) == 1) then
            return redis.call('expire', key, ttl)
        elseif (redis.call('ttl', key) == -1) then
            return redis.call('expire', key, ttl)
        end

        return 0
EOF, 3, 'lock', $this->_lockFlag, 5);

        return $result;
    }

    // 解锁
    public function unlock($key)
    {
        if ($this->_lockFlag) {
            $result = Redis::eval(<<<EOF

            local key = KEYS[1]
            local value = KEYS[2]

            if (redis.call('exists', key) == 1 and redis.call('get', key) == value)
            then
                return redis.call('del', key)
            end

            return 0
EOF, 3, 'lock', $this->_lockFlag);
        }
        return $result;
    }
}
