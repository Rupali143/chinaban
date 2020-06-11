<?php

namespace App\Repositories;

use App\Model\Category;
use App\Repositories\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface{

	public function all(){
		$categries = Category::all();
		return $categries;
	}
}