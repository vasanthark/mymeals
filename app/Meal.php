<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model {

    public $table = "meals";
    protected $primaryKey = 'meal_id';
    protected $fillable =  ['offer_id', 'title', 'price', 'meal_date', 'status'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'title' => 'required|unique:meals,title,' . ($id ? "$id" : 'NULL') . ',meal_id',
            'price' => 'required|numeric',
            'meal_date' => 'required',
                ], $merge);
    }
    public static function getMeal(){
        $category = Meal::where('status', 1)->lists('title', 'meal_id');
        $category->prepend('--Select Meal--', '');
        return $category;
    }
    public function offer() {
        return $this->belongsTo('App\Offer');
    }
}
