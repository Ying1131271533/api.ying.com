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
            // 这里应该还有个商品规格id
            // $table->unsignedBigInteger('goods_spec_id')->comment('商品规格id');
            // 这里应该还有个记录商品属性和规格名称的数组，参考淘宝
            // 'specs' => [ '布料：黄色', '尺寸：L' ],
            // $table->json('specs')->comment('商品规格');
            $table->integer('number')->default(1)->comment('数量');
            $table->tinyInteger('is_checked')->default(0)->comment('是否勾选：0 否 1 是');
            $table->timestamps();

            $table->index(['user_id', 'goods_id']);
            // 如果做了商品规格就写下面这个
            // $table->index(['user_id', 'goods_id', 'spec_id']);

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
