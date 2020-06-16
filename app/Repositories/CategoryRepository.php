<?php

namespace App\Repositories;

use App\Model\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryRepository implements CategoryInterface{

	protected function validateCategory($categoryRequest){
        $validateData = $categoryRequest->validate([
         'category' => 'required'
        ]);
    }

	public function all(){
		$categries = DB::table('categories as c1') 
					->SELECT('c1.en_name as category','c2.en_name as parentCategory','c1.id')
					->leftJoin('categories as c2','c1.parent_category', '=', 'c2.id')
					->where('c1.deleted_at', NULL)
				    ->get();
		return $categries;
	}

	public function save($data){
		$result = $this->validateCategory($data);
		if(is_null($data->category_id)){
			return Category::create(['en_name'=>$data->category,'parent_category'=>$data->parent_category]);
		}else{
			return Category::updateOrCreate(
		   ['id' =>  $data->category_id],
		   ['en_name' =>  $data->category,'parent_category' => $data->parent_category]);
		}
  
	}

	public function delete($id){
		return Category::find($id)->delete();
	}
}