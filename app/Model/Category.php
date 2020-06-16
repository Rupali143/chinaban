<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['id','parent_category','en_name'];

    protected $dates = ['deleted_at'];
}
