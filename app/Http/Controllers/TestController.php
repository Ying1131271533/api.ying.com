<?php

namespace App\Http\Controllers;

use App\Services\Lib\RedisLock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends BaseController
{
    public function index(Request $request)
    {


        $satrt = microtime(true);
        $total = 0;
        for($i = 0;$i < 1000000;$i++){
        $total += $i;
        }
        echo "Count:".$i.",Total".$total."\n";
        $end = microtime(true);

        $spend = floor(($end - $satrt)*1000);
        echo $end."\n";
        echo $spend."\n";

        echo "JIT is " . (ini_get('opcache.jit') ? "enabled" : "disabled") . "\n";

        exit;
        return ['name' => '阿卡丽'];
        // Redis::set('akali', 100);return 1;
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
