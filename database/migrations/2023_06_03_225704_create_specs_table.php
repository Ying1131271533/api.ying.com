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
        Schema::create('specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_type_id')->comment('商品类型id');
            $table->char('name', 25)->comment('商品规格的名称');
            $table->tinyInteger('is_index')->unsigned()->default(0)->comment('是否检索: 0 否 1 是 显示在前端的商品筛选里面');
            $table->integer('sort')->unsigned()->default(50)->comment('排序'); // 老师说默认给50比较好调整排序
            $table->timestamps();

            $table->index('goods_type_id');
            $table->index('name');
            $table->index('is_index');
            $table->foreign('goods_type_id')->references('id')->on('goods_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specs');
    }
};
