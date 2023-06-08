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
        Schema::create('spec_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spec_id')->comment('商品规格id');
            $table->char('name', 25)->comment('商品规格的选项');

            $table->index('spec_id');
            $table->index('name');

            $table->foreign('spec_id')->references('id')->on('specs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spec_items');
    }
};
