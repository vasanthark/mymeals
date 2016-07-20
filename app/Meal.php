<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model {

    public $item_id;
    public $table = "meals";
    protected $primaryKey = 'meal_id';
    protected $fillable = ['title', 'status', 'item_id'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'title' => 'required',           
            'item_id' => 'required',
                ], $merge);
    }

    public static function getMeal($today=null) {
        if($today!="")
            $category = Meal::where('status', 1)->lists('title', 'meal_id');
        else
            $category = Meal::where('status', 1)->lists('title', 'meal_id');
        
        return $category;
    }
   
    public function offer() {
        return $this->belongsTo('App\Offer');
    }

    public function item() {
        return $this->belongsToMany('App\Item', 'meals_items', 'meal_id', 'item_id');
    }

}
