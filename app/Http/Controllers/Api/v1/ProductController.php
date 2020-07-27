<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserProduct;
use App\Model\Product;
use App\Repositories\Product\ProductInterface as ProductInterface;

class ProductController extends Controller
{

	/**
    * Initialize Repository
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @return \App\Repositories\ProductRepository
    */ 
	private $productRepository;
	public function __construct(ProductInterface $productRepository){
		$this->productRepository = $productRepository;
	}

	/** Fetch products based on category_id
    *@Author Rupali <rupali.satpute@neosofttech.com>
    * @param  $request
    * @return json $categoryProduct
	*/

	public function fetchProduct(Request $request){
		try {
			$categoryProduct = $this->productRepository->fetchProduct($request);
			return $categoryProduct;
		} catch (Exception $e) {
			return response()->json(['message' => $e->getMessage()], $e->getStatus());
		}   
	}
}
