<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('user_id')->unsigned();            
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone', 255);            
            $table->text('address');            
            $table->string('latitude', 100);
            $table->string('longitude', 255);            
            
            //Foreign Keys
            $table->foreign('user_id')
                    ->references('id')->on('users')
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
