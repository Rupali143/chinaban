<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryInterface as CategoryInterface;

class ApiCategoryController extends Controller
{
	/**
    * Repository Initialized
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  
    * @return 
    */
	private $categoryRepository;

	public function __construct(CategoryInterface $categoryRepository){
		$this->categoryRepository = $categoryRepository;
	}

    /**
    * Fetch Category 
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  
    * @return $category in JSON format
    */
    public function fetchCategory(){
       return $categories = $this->categoryRepository->getCategory();
    }

    /**
    * Fetch Sub- Category
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $id
    * @return $category in JSON format
    */

    public function fetchSubcategory(Request $request){
       return $categories = $this->categoryRepository->fetchSubcategory($request->category_id);
    }
}
