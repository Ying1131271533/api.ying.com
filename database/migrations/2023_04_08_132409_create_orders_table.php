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
            $table->string('order_no')->comment('订单单号');
            $table->integer('user_id')->comment('买家id');
            $table->double('amount')->comment('总金额 单位分');
            $table->tinyInteger('status')->default(1)->comment('订单状态: 1 下单 2 支付 3 发货 4 收货(结单)');
            $table->integer('address_id')->comment('收货地址id');
            $table->string('express_type')->comment('快递类型: SF YT YD');
            $table->string('express_no')->comment('快递单号');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->string('pay_type')->nullable()->comment('支付类型：支付宝 微信');
            $table->string('trade_no')->nullable()->comment('支付单号');
            $table->timestamps();
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
