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
            $table->id();
            $table->integer('user_id')->comment('创建商品的用户id');
            $table->integer('category_id')->comment('分类id');
            $table->string('title', 255)->comment('标题');
            $table->string('cover', 100)->comment('封面图');
            $table->string('description', 255)->comment('描述');
            $table->json('pics')->comment('详情图集');
            $table->double('price', 10, 2)->comment('价格');
            $table->integer('stock')->comment('库存');
            $table->tinyInteger('is_on')->default(0)->comment('上架：0 否 1 是');
            $table->tinyInteger('is_recommend')->default(0)->comment('推荐商品：0 否 1是');
            $table->mediumText('details')->comment('商品详情');
            $table->timestamps();
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
