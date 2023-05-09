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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('用户id');
            $table->string('name', 20)->comment('收货人名称');
            $table->string('citie_code')->comment('地址表cities中的县级或乡镇code');
            $table->string('address', 60)->comment('详细地址');
            $table->string('phone', 11)->comment('手机号');
            $table->tinyInteger('is_default')->default(0)->comment('默认地址: 0 否 1 是');
            $table->timestamps();

            $table->index('user_id');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
