<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('user_id')->unsigned();
            $table->integer('meal_id')->unsigned();                        
            $table->float('subtotal'); 
            $table->float('offer_price'); 
            $table->float('grandtotal'); 
            $table->integer('status')->default(1);
            $table->timestamps();
           
            //Foreign Keys
            $table->foreign('user_id')
                    ->references('id')->on('users')
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
