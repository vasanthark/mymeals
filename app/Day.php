<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Day extends Model {

    public $table = "days";
    protected $primaryKey = 'day_id';
    protected $fillable = ['meal_id', 'price'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'meal_id' => 'required',     
            'day_image' => 'required|Mimes:jpeg,png,gif',
            'price' => 'required|numeric',
                ], $merge);
    }
   
    public function meal() {
        return $this->belongsTo('App\Meal');
    }
    
    public function offer() {
        return $this->belongsTo('App\Offer');
    }


}
