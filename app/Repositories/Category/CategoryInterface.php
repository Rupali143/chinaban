<?php 

namespace App\Repositories\Category;

use App\Model\Category;
use Illuminate\Http\Request;

interface CategoryInterface{


	//Declaration functions for Web
	public function all();
	public function save($data);
	public function delete($id);

	//Declaration functions for API
	public function getCategory();
	public function fetchSubcategory($id);
}