<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model {

    public $table = "user_infos";
    protected $primaryKey = 'id';
    protected $fillable =  ['user_id', 'first_name', 'last_name', 'phone', 'address', 'latitude', 'longitude'];

    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'first_name' => 'required',           
            'address' => 'required',
            'phone' => 'required',
                ], $merge);
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
}
