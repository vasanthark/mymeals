<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('offers', function (Blueprint $table) {
            $table->increments('offer_id');
            $table->string('offer_type',55);
            $table->string('offer_name', 255);
            $table->string('offer_image', 255);
            $table->float('offer_price');            
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
