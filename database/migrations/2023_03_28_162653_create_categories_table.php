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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // 自动递增
            // $table->unsignedBigInteger('id', true); // 自动递增
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父级id');
            $table->char('category_path')->comment('分类路径，例如：1,2,5 分类名称是：家用电器,大家电,冰箱');
            $table->char('name', 25)->comment('分类名称');
            $table->char('url', 100)->nullable()->comment('链接'); // 菜单那边可能要用到
            $table->tinyInteger('status')->default(1)->comment('状态：0 禁用 1 正常');
            $table->tinyInteger('level')->default(1)->comment('级别：1 2 3...');
            $table->char('image', 100)->nullable()->comment('图片');
            $table->char('icon', 25)->nullable()->comment('图标');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();

            $table->index('name');
            // $table->index('parent_id');

            // 主键 不能用...
            // $table->primary(['id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
