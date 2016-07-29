<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model {

    public $table = "item_types";
    protected $primaryKey = 'item_type_id';
    protected $fillable =  ['name'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'type_name' => 'required|unique:item_types,type_name,' . ($id ? "$id" : 'NULL') . ',item_type_id',
                ], $merge);
    }
    
    public static function getItemTypes(){          
        $types = ItemType::lists('type_name', 'item_type_id');       
        return $types;
    }
    
}
