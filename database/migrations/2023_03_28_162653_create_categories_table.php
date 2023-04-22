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
            $table->bigIncrements('id'); // 自增主键
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父级id');
            $table->char('name', 20)->comment('分类名称');
            $table->tinyInteger('status')->default(1)->comment('状态：0 禁用 1 正常');
            $table->tinyInteger('level')->default(1)->comment('级别：1 2 3...');
            $table->timestamps();

            $table->index('parent_id');
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
