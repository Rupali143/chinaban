<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    
    protected $table = 'admin_user';

    public $fillable = ['id','username','password'];

    protected $hidden = ['created_at', 'updated_at'];
}
