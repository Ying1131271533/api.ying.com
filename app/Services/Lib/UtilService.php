<?php
namespace App\Services\Lib;

use Illuminate\Support\Facades\Cache;

class UtilService
{
    /**
     * 生成唯一单据号
     *
     * @param string    $key    缓存key
     * @return string
     */
    public function generateReceiptCode(string $key = 'order_on_incr')
    {
        $lock = Cache::lock('lock_order_on_incr', 10); // 锁定10秒

        if ($lock->get()) {

            // 逻辑代码
            $order_on = date('Ymd') . sprintf("%06d", Cache::store('redis')->increment($key));

            // 释放锁
            $lock->release();
        }

        return $order_on;
    }
}
