<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	protected $guarded = [];
	
	protected $table = 'categories';

    protected $fillable = ['id','en_name','parent_category'];

    protected $dates = ['deleted_at'];


    public function image(){
    	return $this->morphOne(Image::class,'imageable');
    }

    public function getImage(){
        return $this->hasOne(Image::class,'imageable_id','id');
    }

    public function children()
	{
	    return $this->hasMany(Category::class,'id','parent_category');
	}

	public function parent()
	{
	    return $this->belongsTo(Category::class,'id','parent_category');
	}
}
