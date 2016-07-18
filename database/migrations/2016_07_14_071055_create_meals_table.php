<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->increments('meal_id');
            $table->integer('offer_id')->unsigned();     
            $table->string('title',255);            
            $table->float('price');     
            $table->date('meal_date');     
            $table->integer('status')->default(1);            
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
         //
    }
}
