<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\UserProduct;
use App\Model\User;
use App\Repositories\Category\CategoryInterface as CategoryInterface;
use DataTables;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
	 /**
    * Category Repository Initialized
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
    * Index for display dropdown of Category.
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  
    * @return view
    */
	public function index(){
		$categories = $this->categoryRepository->all();
		return view('admin.search.manufacturer',compact('categories'));
	}


	/**
    * Display dynamic dataTable of search Manufacturer based on category.
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $request
    * @return $userData with DataTable
    */
	public function manufacturer(Request $request){
		$user_data = UserProduct::where('category_id',$request->parent_category)->			pluck('user_id');
		$userData = User::where('is_manufacture',1)->whereIn('id',$user_data)->get();
		return Datatables::of($userData)
		->addIndexColumn()
		->make(true);
	}

    /**
    * Find user_id for search manufacturer.
    *@Author Rupali <rupali.satpute@neosofttech.com>
    *
    * @param  $id
    * @return $users
    */
	public function findUserId($id){
		return $users = UserProduct::find($id);
	}
}
