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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_type_id')->comment('商品类型id');
            $table->char('name', 25);
            $table->tinyInteger('is_index')->unsigned()->default(0)->comment('是否检索: 0 否 1 是 显示在前端的商品筛选里面');
            $table->tinyInteger('input_type')->unsigned()->default(0)->comment('输入方式: 0 手工录入 1 列表中选择 2 多行文本框');
            $table->char('values', 255)->nullable()->comment('可选值列表，录入方式为手工和或者多行文本时，此值则不需要');
            $table->integer('sotr')->unsigned()->default(0)->comment('排序');
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
        Schema::dropIfExists('attribute');
    }
};
