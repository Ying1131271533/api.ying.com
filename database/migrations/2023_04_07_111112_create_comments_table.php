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
            $table->integer('user_id')->comment('买家id');
            $table->integer('goods_id')->comment('商品id');
            $table->tinyInteger('rate')->default(1)->comment('评论等级：1 好评 2 中评 3 差评');
            $table->string('content', 255)->comment('评论的内容');
            $table->string('reply', 255)->nullable()->comment('商家的回复');
            $table->json('pics')->nullable()->comment('评论图集');
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
        Schema::dropIfExists('comments');
    }
};
