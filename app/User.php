<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'role', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getId() {
        return $this->id;
    }
    
    public static function rules($id = 0, $merge = []) {
        return array_merge([
            'email' => 'required|email|unique:users,email,' . ($id ? "$id" : 'NULL') . ',id',
            'username' => 'required|unique:users,username,' . ($id ? "$id" : 'NULL') . ',id',
            'password' => 'required|unique:users,password,' . ($id ? "$id" : 'NULL') . ',id',
                ], $merge);
    }
     public function userinfo()
    {
        return $this->hasOne('App\UserInfo');
    }
}
