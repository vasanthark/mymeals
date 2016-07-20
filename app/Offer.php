<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model {

    public $table = "offers";
    protected $primaryKey = 'offer_id';
    protected $fillable =  ['offer_type', 'offer_name', 'offer_image', 'offer_price', 'status'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'offer_name' => 'required|unique:offers,offer_type,' . ($id ? "$id" : 'NULL') . ',offer_id',
//            'offer_type' => 'required',            
            'offer_image' => 'required|Mimes:jpeg,png,gif',
            'offer_price' => 'required',
            'status' => 'required',
                ], $merge);
    }
    public static function getOffer(){
        $category = Offer::where('status', 1)->lists('offer_name', 'offer_id');
        $category->prepend('-- None --', '');
        return $category;
    }

}
