<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     info('阿卡丽');
        // })->everyMinute();

        // 定时检测订单状态，超过十分钟未支付的数据作废
        // 真实的项目中，不会这么做，真实的项目一般会使用长连接，订单过期了，直接作废
        // 这里一般处理 凌晨备份数据库 清空日志表、、等等之类的业务需求
        $schedule->call(function () {
            $orders = Order::where('status', 1)
            ->where('created_at', '<', now()->subDays(1))
            ->with('details.goods')
            ->get();

            // 循环订单，修改订单状态，还原商品库存
            try {
                DB::beginTransaction();

                foreach ($orders as $order) {
                    // 订单状态：过期
                    $order->status = 5;
                    $order->save();
                    // 返还商品库存
                    foreach ($order->details as  $detail) {
                        $detail->goods->increment('stock', $detail->number);
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
