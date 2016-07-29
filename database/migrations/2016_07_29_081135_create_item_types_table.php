<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('item_types', function (Blueprint $table) {
            $table->increments('item_type_id');
            $table->string('type_name');           
            $table->timestamps();
        });
        
        DB::table('item_types')->insert([
            [
               'type_name' => 'Main Item'
            ], [ 
               'type_name' => 'Special Item'
            ],
            [ 
               'type_name' => 'Left Side Item'
            ],
            [ 
               'type_name' => 'Right Side Item'
            ],
            [ 
               'type_name' => 'Other Item'
            ]
          ]       
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::drop('item_types');
    }
}
