<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealsItem extends Model {

    public $table = "meals_items";
    protected $primaryKey = 'mi_id';
    protected $fillable =  ['item_id', 'meal_id'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([            
            'meal_id' => 'required',
            'item_id' => 'required',
                ], $merge);
    }
    public function meal() {
        return $this->belongsTo('App\Meal', 'meal_id', 'meal_id');
    }
    
    public function item() {
        return $this->belongsTo('App\Item', 'item_id', 'item_id');
    }
}
