<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('meals_items', function (Blueprint $table) {
            $table->increments('mi_id');
            $table->integer('item_id')->unsigned();     
            $table->integer('meal_id')->unsigned();
                    
            //Foreign Keys
            $table->foreign('item_id')
                    ->references('item_id')->on('items')
                    ->onDelete('cascade');
            $table->foreign('meal_id')
                    ->references('meal_id')->on('meals')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
