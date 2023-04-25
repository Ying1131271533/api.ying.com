<?php
namespace App\Services\Lib;

use Illuminate\Support\Facades\Cache;

class UtilService
{
    /**
     * 生成唯一单据号
     *
     * @param string    $key    缓存key前缀
     * @return string
     */
    public function generateReceiptCode(string $key = 'order_on_incr')
    {
        $lock = Cache::lock('lock_order_on_incr', 10); // 锁定10秒

        if ($lock->get()) {

            // 获取年月日
            $date = date('Ymd');
            // 缓存key
            $key .= "_{$date}";
            if(!Cache::store('redis')->has($key)) {
                Cache::store('redis')->set($key, 0, cache_time('dawn_time'));
            }

            // 获取订单号
            $order_on = $date . sprintf("%06d", Cache::store('redis')->increment($key));

            // 释放锁
            $lock->release();
        }

        return $order_on;
    }
}
