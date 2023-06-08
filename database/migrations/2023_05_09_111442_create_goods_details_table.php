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
        Schema::create('goods_details', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_id')->comment('商品id');
            $table->json('pics')->comment('商品图册');
            $table->mediumText('content')->comment('详情内容');

            $table->index('goods_id');
            $table->foreign('goods_id')->references('id')->on('goods');
            $table->primary('goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_details');
    }
};
