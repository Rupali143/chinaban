<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
	use SoftDeletes;
	protected $guarded = [];

	protected $fillable = [
		'image', 'imageable_id', 'imageable_type','image_location'
	];

	public function imageable(){
		return $this->morphTo();
	}

	public function fetchImage(){
		return $this->morphOne(Category::class,'getImage');
	}

}