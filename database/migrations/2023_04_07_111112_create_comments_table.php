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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('买家id');
            $table->unsignedBigInteger('order_id')->comment('订单id');
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->tinyInteger('rate')->default(1)->comment('评论等级：1 好评 2 中评 3 差评');
            $table->string('content', 255)->comment('评论的内容');
            $table->string('reply', 255)->nullable()->comment('商家的回复');
            $table->json('pics')->nullable()->comment('评论图集');
            $table->timestamps();

            // 单个索引
            $table->index('user_id');
            $table->index('order_id');
            $table->index('goods_id');
            $table->index('rate');
            // 外键约束
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('goods_id')->references('id')->on('goods');
            // 主键
            // $table->primary(['id', 'user_id', 'goods_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
