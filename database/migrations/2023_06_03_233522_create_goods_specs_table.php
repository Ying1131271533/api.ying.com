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
        Schema::create('goods_specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->char('item_ids', 120)->comment('套餐组合id');
            $table->char('item_ids_name', 120)->comment('套餐组合名称');
            $table->decimal('spec_price')->unsigned()->default(0)->comment('套餐价格');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->integer('sales')->unsigned()->default(0)->comment('销量');
            $table->timestamps();
            // 单个索引
            $table->index('goods_id');
            // 外键约束
            $table->foreign('goods_id')->references('id')->on('goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_specs');
    }
};
