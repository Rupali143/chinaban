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

    //Saved images
    public function image(){
    	return $this->morphOne(Image::class,'imageable');
    }

    // fetched images for edit
    public function getImage(){
        return $this->hasOne(Image::class,'imageable_id','id');
    }

    //fetched child category
    public function childs()
	{
	    return $this->hasMany(Self::class,'parent_category','id');
	}

	//fetched parent category
	public function parent()
	{
	    return $this->belongsTo(Self::class,'parent_category');
	}

}
