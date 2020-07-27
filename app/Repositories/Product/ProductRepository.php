<?php

namespace App\Repositories\Product;

use App\Model\Product;
use App\Model\Category;
use App\Repositories\Product\ProductInterface;
use Illuminate\Http\Request;
use App\Model\UserProduct;


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
	

	/**
    * Get all products
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  void
    * @return $product
	*/
	public function all(){
		$products = Product::with('category')->get();
		return $products;
	}

	/**
    * Save product details
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $data
    * @return $product
	*/
	public function save($data){
		$validateRules = $this->validateProduct($data);
		if(is_null($data->product_id)){
			$product = Product::create(['en_name'=>$data->product,'category_id'=>$data->subcategory,'product_detail'=>$data->product_detail]);
			return $product;
		}else{
			$updateProduct = Product::updateOrCreate(
				['id' =>  $data->product_id],
				['en_name' =>  $data->product,'category_id' =>  $data->subcategory,'product_detail' => $data->product_detail]);
			return $updateProduct;
		}

	}

	/**
    * Delete product details
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $id
    * @return $productDelete
	*/
	public function delete($id){
		$productDelete = Product::find($id)->delete(); 
		return $productDelete;
	}

	/**
    * Fetch subCategory from Parent category
    *@Author Bharti <bharati.tadvi@neosofttech.com>
	*
    * @param  $requestData
    * @return $subCategories
	*/
	public function fetchSubCategory($requestData){
		$category = $requestData->category_id;
		$subCategories= Category::where('parent_category', '=', $category)->get();
		return $subCategories;
	}





	// API
	/**
    * Fetch products based on category_id
    *@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $requestData
    * @return $categoryProduct
	*/
	public function fetchProduct($requestData){
		$fetchCategoryId = UserProduct::where('category_id',$requestData->category_id)->where('is_import','=','1')->where('deleted_at',NULL)->pluck('product_id');
		$categoryProduct = Product::whereIn('id',$fetchCategoryId)->where('deleted_at',NULL)->get();
		if(count($categoryProduct) > 0)
		{
			return response()->json([
				'code' => "200",
				'message' => "Product fetched successfully",
				'data'    => $categoryProduct,
			]);
		}else{
			return response()->json([
				'code' => "412",
				'message' => "Product not fetched",
				'data'    => $categoryProduct
			]);
		} 
	}
}