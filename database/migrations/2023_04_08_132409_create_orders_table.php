<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('买家id');
            $table->unsignedBigInteger('order_no')->unique()->comment('订单单号');
            $table->unsignedDecimal('amount', 10, 2)->comment('总金额');
            $table->tinyInteger('status')->default(1)->comment('订单状态: 1 下单 2 支付 3 发货 4 收货 5 过期(未支付) 6 退款 7 退换 8 已评价 10 支付异常(支付金额对不上等)');
            $table->char('name', 20)->comment('收货人');
            $table->char('phone', 11)->comment('电话');
            $table->char('address', 60)->comment('完整收货地址');
            $table->char('express_type', 10)->nullable()->comment('快递类型: SF YT YD');
            $table->char('express_no', 20)->nullable()->comment('快递单号');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->char('pay_type', 10)->nullable()->comment('支付类型：支付宝 微信 微信小程序');
            $table->char('trade_no', 40)->nullable()->comment('支付单号');
            $table->tinyInteger('pay_status')->default(0)->comment('支付状态');
            $table->timestamps();

            // 单个索引
            $table->index('user_id');
            $table->index('order_no');
            $table->index('trade_no');
            $table->index('status');
            // 外键约束
            $table->foreign('user_id')->references('id')->on('users');
            // 主键
            // $table->primary(['id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
