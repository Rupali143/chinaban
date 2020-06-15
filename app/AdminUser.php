<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Model
{
    use SoftDeletes;

    protected $table = 'admin_user';

    public $fillable = ['id','username','password'];

    protected $hidden = ['created_at', 'updated_at'];
}
