<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    public $item_id;
    public $table = "orders";
    protected $primaryKey = 'order_id';     
    protected $fillable =  ['user_id', 'meal_id', 'subtotal', 'offer_price', 'grandtotal', 'status'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'user_id' => 'required',
            'meal_id' => 'required',            
                ], $merge);
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }
}
