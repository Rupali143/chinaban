<?php 

namespace App\Repositories\Category;

use App\Model\Category;
use Illuminate\Http\Request;

interface CategoryInterface{

	public function all();
	public function save($data);
	public function delete($id);
}