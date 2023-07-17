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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('买家id');
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->char('spec', 120)->comment('套餐组合，例如：1_3');
            $table->char('spec_name', 120)->comment('套餐组合名称，例如：颜色_白色，网络_5G，就记录规格值的名称，前端可以直接使用');
            $table->unsignedSmallInteger('number')->default(1)->comment('数量');
            $table->tinyInteger('is_checked')->default(0)->comment('是否选中：0 否 1 是');
            $table->timestamps();

            $table->index(['user_id', 'goods_id']);

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('carts');
    }
};
