<?php
namespace App\Services\Lib;

use Illuminate\Support\Facades\Redis;

class RedisLock
{
    /**
     * @var 当前锁标识，用于解锁
     */
    private $_lockFlag;
    private $_redis;

    public function __construct()
    {
        $this->_redis = Redis::connection();
    }

    public function lock($key = 'lock', $expire = 5)
    {
        $now = time();
        $expireTime = $expire + $now;
        if ($this->_redis->setnx($key, $expireTime)) {
            $this->_lockFlag = $expireTime;
            return true;
        }

        // 获取上一个锁的到期时间
        $currentLockTime = $this->_redis->get($key);
        if ($currentLockTime < $now) {
            /* 用于解决
            C0超时了,还持有锁,加入C1/C2/...同时请求进入了方法里面
            C1/C2都执行了getset方法(由于getset方法的原子性,
            所以两个请求返回的值必定不相等保证了C1/C2只有一个获取了锁) */
            $oldLockTime = $this->_redis->getset($key, $expireTime);
            if ($currentLockTime == $oldLockTime) {
                $this->_lockFlag = $expireTime;
                return true;
            }
        }

        return false;
    }

    // 上锁
    public function lockByLua($key = 'lock', $expire = 5)
    {
        // ttl - 过期时间
        $script = <<<'LUA'

            local key = KEYS[1]
            local value = KEYS[2]
            local ttl = KEYS[3]

            if (redis.call('setnx', key, value) == 1) then
                return redis.call('expire', key, ttl)
            elseif (redis.call('ttl', key) == -1) then
                return redis.call('expire', key, ttl)
            end

            return 0
LUA;

        $this->_lockFlag = md5(microtime(true));

        $result = Redis::eval($script, 3, $key, $this->_lockFlag, $expire);
        return $result;
    }

    // 解锁
    public function unlock($key = 'lock')
    {
        $script = <<<'LUA'

            local key = KEYS[1]
            local value = KEYS[2]

            if (redis.call('exists', key) == 1 and redis.call('get', key) == value)
            then
                return redis.call('del', key)
            end

            return 0
LUA;

        if ($this->_lockFlag) {
            $result = Redis::eval($script, 2, $key, $this->_lockFlag);
            return $result;
        }
    }

}

/*
$redisLock = new RedisLock();

// 记录此次redis锁的标识key，不是要锁住的redis值(例如：库存)
$key = 'lock';
if ($redisLock->lockByLua($key)) {
    // to do...业务代码
    $redisLock->unlock($key);
} */
