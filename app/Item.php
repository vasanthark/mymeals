<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    public $table = "items";
    protected $primaryKey = 'item_id';
    protected $fillable =  ['name','item_type_id'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'item_type_id' => 'required',
            'name' => 'required|unique:items,name,' . ($id ? "$id" : 'NULL') . ',item_id',
            'item_image' => 'required|Mimes:jpeg,png,gif',
                ], $merge);
    }
    
    public static function getItem(){
        $category = Item::lists('name', 'item_id');
        $category->prepend('--Select Item--', '');
        return $category;
    }
    
     public function itemType() {
        return $this->belongsTo('App\ItemType');
    }
    
}
