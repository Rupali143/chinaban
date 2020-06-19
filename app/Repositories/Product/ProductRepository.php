<?php

namespace App\Repositories\Product;

use App\Model\Product;
use App\Repositories\Product\ProductInterface;
use Illuminate\Http\Request;

class ProductRepository implements ProductInterface{

	public $product;


    function __construct(Product $product) {
	$this->product = $product;
    }
	
	/**
	* Validate product form.
	*@author Bharti<bharati.tadvi@neosofttech.com>
	* 
	* @param $userRequest
	* @return $rules
    */
    protected function validateProduct($requestData){

        $validateData = $requestData->validate([
			'product' => 'required',
			'category_id' => 'required',
			'product_detail'=>'required'
		   ]);
	}
	
	public function all(){
		$products = Product::with('category')->get();
		return $products;
	}

	public function save($data){
		$validateRules = $this->validateProduct($data);
		if(is_null($data->product_id)){
            $product = Product::create(['en_name'=>$data->product,'category_id'=>$data->category_id,'product_detail'=>$data->product_detail]);
			return $product;
		}else{
			$updateProduct = Product::updateOrCreate(
		   ['id' =>  $data->product_id],
		   ['en_name' =>  $data->product,'product_detail' => $data->product_detail]);
			return $updateProduct;
		}
  
	}

	public function delete($id){
		$productDelete = Product::find($id)->delete(); 
		return $productDelete;
	}
}