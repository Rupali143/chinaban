<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    public $fillable = ['id','mobile_number','name','dob','know_about_product','is_manufacture'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = ['created_at', 'updated_at'];

    //user_product have many users.fetched users.
    public function userproduct(){
        return $this->hasMany(UserProduct::class);
    }

    
}
