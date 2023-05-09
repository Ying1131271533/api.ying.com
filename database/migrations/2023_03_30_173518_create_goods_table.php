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
        Schema::create('goods', function (Blueprint $table) {
            // $table->bigIncrements('id'); // 自增主键
            $table->id(); // 自增主键
            $table->unsignedBigInteger('user_id')->comment('创建商品的用户id');
            $table->unsignedBigInteger('category_id')->comment('分类id');
            $table->unsignedBigInteger('brand_id')->comment('品牌id');
            $table->char('title', 50)->unique()->comment('标题');
            $table->char('cover', 100)->comment('封面图');
            $table->unsignedDecimal('market_price', 10, 2)->default(0)->comment('市场价格');
            $table->unsignedDecimal('show_price', 10, 2)->default(0)->comment('购买价格');
            $table->unsignedinteger('stock')->comment('库存');
            $table->tinyInteger('is_on')->default(0)->comment('上架：0 否 1 是');
            $table->tinyInteger('is_recommend')->default(0)->comment('推荐商品：0 否 1是');
            $table->mediumText('details')->comment('商品详情');
            $table->timestamps();

            // 单个索引
            $table->index('user_id');
            $table->index('category_id');
            $table->index('brand_id');

            $table->index('title');
            $table->index('is_on');
            $table->index('is_recommend');

            // 复合索引
            // 这里会生成 'user_id,category_id' 和 'category_id' 两个索引
            // $table->index(['user_id', 'category_id']);

            // 外键约束
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');

            // 主键
            // $table->primary(['id', 'user_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
};
