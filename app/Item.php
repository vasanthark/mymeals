<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    public $table = "items";
    protected $primaryKey = 'item_id';
    protected $fillable =  ['name'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'name' => 'required|unique:items,name,' . ($id ? "$id" : 'NULL') . ',item_id',
                ], $merge);
    }
    public static function getItem(){
        $category = Item::lists('name', 'item_id');
        $category->prepend('--Select Item--', '');
        return $category;
    }
    
}
