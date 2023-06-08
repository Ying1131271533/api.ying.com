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
        Schema::create('goods_spec_item_pics', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->unsignedBigInteger('spec_item_id')->comment('商品规格选项的id');
            $table->string('path', 100)->comment('商品规格选项显示的图片路径');

            // 单个索引
            $table->index('goods_id');
            $table->index('spec_item_id');
            // 外键约束
            $table->foreign('goods_id')->references('id')->on('goods');
            $table->foreign('spec_item_id')->references('id')->on('spec_items');

            // 主键
            $table->primary(['goods_id', 'spec_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spec_item_pics');
    }
};
