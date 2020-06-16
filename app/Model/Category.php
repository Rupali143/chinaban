<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	
	protected $table = 'categories';

    protected $fillable = ['id','en_name','parent_category'];

    protected $dates = ['deleted_at'];
}
