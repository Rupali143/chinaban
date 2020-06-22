<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Model
{
    use SoftDeletes;

    
    protected $table = 'admin_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['id','username','password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    protected $hidden = ['created_at', 'updated_at'];
}
