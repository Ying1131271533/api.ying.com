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
        Schema::create('goods_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->unsignedBigInteger('attribute_id')->comment('商品属性id');
            $table->char('attr_value', 25)->comment('属性值');
            $table->timestamps();

            // 单个索引
            $table->index('attribute_id');
            $table->index('goods_id');

            // 外键约束
            $table->foreign('goods_id')->references('id')->on('goods');
            $table->foreign('attribute_id')->references('id')->on('orders');

            // 主键
            $table->primary(['goods_id', 'attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_attributes');
    }
};
