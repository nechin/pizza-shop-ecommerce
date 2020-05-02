<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPizzaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pizza', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('image');
            $table->unsignedSmallInteger('size');
            $table->unsignedSmallInteger('weight');
            $table->unsignedFloat('price');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ingredient', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pizza_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('pizza_id');
            $table->unsignedBigInteger('ingredient_id');

            $table->foreign('pizza_id')->references('id')->on('pizza');
            $table->foreign('ingredient_id')->references('id')->on('ingredient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pizza_ingredients');
        Schema::dropIfExists('pizza');
        Schema::dropIfExists('ingredient');
    }
}
