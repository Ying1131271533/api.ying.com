<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 订单商品表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('订单id');
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->char('spec', 120)->comment('套餐组合，例如：1_3');
            $table->char('spec_name', 120)->comment('套餐组合名称，例如：颜色_白色,网络_5G，就记录规格值的名称，前端可以直接使用');
            $table->unsignedDecimal('market_price', 10, 2)->default(0)->comment('市场价格');
            $table->unsignedDecimal('shop_price', 10, 2)->default(0)->comment('购买价格');
            $table->unsignedSmallInteger('number')->comment('数量'); // 65535
            $table->timestamps();

            // 单个索引
            $table->index('order_id');
            $table->index('goods_id');

            // 复合索引
            // 这样会生成 'order_id,goods_id' 和 'goods_id' 两个索引
            // $table->index(['order_id', 'goods_id']);

            // 外键约束
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('goods_id')->references('id')->on('goods');

            // 主键
            // $table->primary(['order_id', 'goods_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_goods');
    }
};
