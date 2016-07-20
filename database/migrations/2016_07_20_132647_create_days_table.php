<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //

        Schema::create('days', function (Blueprint $table) {
            $table->increments('day_id');
            $table->string('name');
            $table->integer('meal_id')->unsigned();
            $table->integer('offer_id')->unsigned();
            $table->float('price');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        DB::table('days')->insert([
            [
            'name' => 'Monday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ], [
            'name' => 'Tuesday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ], [
            'name' => 'Wednesday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ], [
            'name' => 'Thursday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ], [
            'name' => 'Friday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ], [
            'name' => 'Saturday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ], [
            'name' => 'Sunday',
            'meal_id' => 0,
            'offer_id' => 0,
            'price' => 0,
            'status' => 1
                ]
         ]       
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('days');
    }

}
