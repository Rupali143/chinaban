<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;
use App\Repositories\Category\CategoryInterface as CategoryInterface;

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
    	dd($request->all());
    }
}
