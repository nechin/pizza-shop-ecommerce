<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function(Blueprint $table) {
            $table->dateTime('to_time')->after('address');
            $table->text('note')->after('to_time')->nullable();
            $table->unsignedTinyInteger('delivery_type')->after('note')->default(0);
            $table->string('currency')->after('delivery_type')->default('EUR');
        });

        Schema::table('pizza', function(Blueprint $table) {
            $table->string('hint')->after('base');
            $table->boolean('vegan')->after('hint');
            $table->unsignedInteger('viewed')->after('vegan')->default(0);
        });

        Schema::table('order_pizzas', function(Blueprint $table) {
            $table->unsignedTinyInteger('base')->after('pizza_id')->default(0); // tomato or cream
            $table->unsignedSmallInteger('count')->after('base');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function(Blueprint $table) {
            $table->dropColumn('to_time');
            $table->dropColumn('note');
            $table->dropColumn('delivery_type');
            $table->dropColumn('currency');
        });
        Schema::table('pizza', function(Blueprint $table) {
            $table->dropColumn('hint');
            $table->dropColumn('vegan');
            $table->dropColumn('viewed');
        });
        Schema::table('order_pizzas', function(Blueprint $table) {
            $table->dropColumn('base');
            $table->dropColumn('count');
        });
    }
}
