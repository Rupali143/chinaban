<?php 

namespace App\Repositories\Product;
use App\Model\Product;
use Illuminate\Http\Request;

interface ProductInterface{

	public function all();
	public function save($data);
	public function delete($id);
	public function fetchSubCategory($requestData);
}