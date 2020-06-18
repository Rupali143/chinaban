<?php

namespace App\Repositories;

use App\Model\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryInterface{

	protected function validateCategory($categoryRequest){
        $validateData = $categoryRequest->validate([
         'category' => 'required',
         'image' => 'required|mimes:jpeg,jpg,png|max:1024',
        ]);
    }

	public function all(){
		// $category  = new Category();
		// $categries = $category->parent();
					//  DB::table('categories as c1') 
					// ->SELECT('c1.en_name as category','c2.en_name as parentCategory','c1.id')
					// ->leftJoin('categories as c2','c1.parent_category', '=', 'c2.id')
					// // ->join('images as c3','c1.id', '=', 'c3.imageable_id')
					// ->where('c1.deleted_at', NULL)
				 //    ->get();
		// return $categries;
		return $category = Category::with('parent','children','image')->get();
	}

	public function save($data){
		$result = $this->validateCategory($data);

		if ($image = $data->file('image')) {
            $destinationPath = storage_path('app/public/images');
            if(!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
                $extension = $image->getClientOriginalExtension();
                $imageName = $image->getClientOriginalName();
                $imageConvertName = md5($imageName).'.'.$extension;
                $image->move($destinationPath, $imageConvertName);

                if(is_null($data->category_id)){
				// $category = Category::create(
				// 	['en_name'=>$data->category,'parent_category'=>$data->parent_category]);

				$category = new Category();
		        $category->en_name = $data->input('category');
		        $category->parent_category = $data->input('parent_category');
		        $category->save();

       			$lastId = $category->id;
				
				$category->image()->create(['image_location' => $imageConvertName,'imageable_id' => $lastId]);
				return $category;
				}else{
					return Category::updateOrCreate(
				   ['id' =>  $data->category_id],
				   ['en_name' =>  $data->category,'parent_category' => $data->parent_category]);
				}

        }



  
	}

	public function delete($id){
		return Category::find($id)->delete();
	}
}