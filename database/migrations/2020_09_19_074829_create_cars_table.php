<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


  Schema::create('cars', function (Blueprint $table) {
    $table->id();
    $table->string('image')->nullable();
    $table->string('name');
    $table->integer('price');
    $table->string('condition');
    $table->integer('year');
    $table->string('color');
    $table->integer('speed');
    $table->unsignedBigInteger('shop_id');
    $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
    $table->unsignedBigInteger('category_id');
    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    $table->unsignedBigInteger('brand_id');
    $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
        Schema::dropIfExists('cars');
    }
}
