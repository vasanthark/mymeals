<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model {

    public $item_id;
    public $table = "meals";
    protected $primaryKey = 'meal_id';
    protected $fillable = ['offer_id', 'title', 'price', 'meal_date', 'status', 'item_id'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'title' => 'required',
            'price' => 'required|numeric',
            'meal_date' => 'required|unique:meals,meal_date,' . ($id ? "$id" : 'NULL') . ',meal_id',
            'item_id' => 'required',
                ], $merge);
    }

    public static function getMeal($today=null) {
        if($today!="")
            $category = Meal::where('meal_date', $today)->where('status', 1)->orderBy('meal_date', 'asc')->lists('title', 'meal_id');
        else
            $category = Meal::where('status', 1)->orderBy('meal_date', 'asc')->lists('title', 'meal_id');
        
        return $category;
    }
   
    public function offer() {
        return $this->belongsTo('App\Offer');
    }

    public function item() {
        return $this->belongsToMany('App\Item', 'meals_items', 'meal_id', 'item_id');
    }

}
