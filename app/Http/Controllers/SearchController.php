<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\UserProduct;
use App\Model\User;
use App\Repositories\Category\CategoryInterface as CategoryInterface;
use DataTables;

class SearchController extends Controller
{
	private $categoryRepository;

	public function __construct(CategoryInterface $categoryRepository){
		$this->categoryRepository = $categoryRepository;
	}
	public function index(){
		$categories = $this->categoryRepository->all();
		return view('search.manufacturer',compact('categories'));
	}

	public function manufacturer(Request $request){
		$user_data = UserProduct::where('category_id',$request->parent_category)->			pluck('user_id');
		$userData = User::where('is_manufacture',1)->whereIn('id',$user_data)->get();
		return Datatables::of($userData)
		->addIndexColumn()
		->make(true);
	}

    //find user_id for search manufacturer
	public function findUserId($id){
		return $users = UserProduct::find($id);
	}
}
