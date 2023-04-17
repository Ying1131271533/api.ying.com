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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('轮播图名称');
            $table->string('img')->comment('轮播图图片');
            $table->string('url', 255)->nullable()->comment('跳转链接');
            $table->integer('sort')->default(1)->comment('排序');
            $table->tinyInteger('status')->default(0)->comment('状态: 0 禁用 1 正常');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
};
