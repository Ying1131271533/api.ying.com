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
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->comment('订单id');
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->double('price')->comment('价格');
            $table->integer('number')->comment('数量');
            $table->timestamps();

            // 单个索引
            $table->index('order_id');
            $table->index('goods_id');
            // 外键约束
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('goods_id')->references('id')->on('goods');
            // 主键
            $table->primary(['order_id', 'goods_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
