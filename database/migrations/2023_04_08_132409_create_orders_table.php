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
            $table->string('order_no')->unique()->comment('订单单号');
            $table->decimal('amount', 10, 2)->comment('总金额');
            $table->tinyInteger('status')->default(1)->comment('订单状态: 1 下单 2 支付 3 交易成功 4 交易关闭(退款、超时未支付) 10 支付异常');
            $table->integer('address_id')->comment('收货地址id');
            $table->string('express_type')->nullable()->comment('快递类型: SF YT YD');
            $table->string('express_no')->nullable()->comment('快递单号');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->string('pay_type')->nullable()->comment('支付类型：支付宝 微信');
            $table->string('trade_no')->nullable()->comment('支付单号');
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
