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
            $table->unsignedBigInteger('admin_id')->comment('创建商品的用户id');
            $table->unsignedBigInteger('category_id')->comment('分类id');
            $table->unsignedBigInteger('brand_id')->comment('品牌id');
            // $table->unsignedTinyInteger('shop_id')->comment('店铺id');
            // $table->char('category_name', 25)->comment('分类名称');
            $table->char('name', 100)->unique()->comment('商品名称');
            $table->char('cover', 100)->comment('封面图');
            $table->unsignedDecimal('market_price', 10, 2)->default(0)->comment('市场价格');
            $table->unsignedDecimal('shop_price', 10, 2)->default(0)->comment('购买价格');
            $table->unsignedInteger('stock')->comment('库存');
            $table->integer('sales')->unsigned()->default(0)->comment('销量');
            $table->unsignedTinyInteger('is_on')->default(0)->comment('上架：0 否 1 是');
            $table->unsignedTinyInteger('is_recommend')->default(0)->comment('推荐商品：0 否 1 是');
            // $table->mediumText('details')->comment('商品详情');
            $table->unsignedBigInteger('view_count')->comment('浏览次数');
            $table->timestamps();


            // 单个索引
            $table->index('admin_id');
            $table->index('category_id');
            $table->index('brand_id');
            // $table->index('shop_id');

            $table->index('title');
            $table->index('is_on');
            $table->index('is_recommend');

            // 复合索引
            // 这里会生成 'admin_id,category_id' 和 'category_id' 两个索引
            // $table->index(['admin_id', 'category_id']);

            // 外键约束
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            // $table->foreign('shop_id')->references('id')->on('shops');

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
