<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model {
    public $item_id;
    public $table = "temporders";
    protected $primaryKey = 'temporder_id';     
    protected $fillable =  ['user_id', 'meal_id','day_id', 'meal_date', 'qty', 'meal_price'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'user_id' => 'required',
            'meal_id'  => 'required',  
            'day_id' => 'required',            
                ], $merge);
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }
    
    public function day() {
        return $this->belongsTo('App\Day');
    }
    
    public function userInfo() {
        return $this->belongsTo('App\UserInfo');
    }
}
