<?php

namespace App\Repositories;

use App\Model\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryInterface{

	/**
    * Validation for  Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $categoryRequest
    * @return $validateData
	*/
	protected function validateCategory($categoryRequest){
		$validateData = $categoryRequest->validate([
			'category' => 'required',
			'image' => 'required|mimes:jpeg,jpg,png|max:1024',
		]);
	}

	/**
    * Fetched all data related Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  null
    * @return $category
	*/

	public function all(){
		return $category = Category::with('parent','childs','image')->get();
	}

	/**
    * Save Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $data
    * @return $category
	*/
	public function save($data){
		if(is_null($data->category_id)){ 

			$result = $this->validateCategory($data);

			if ($image = $data->file('image')) {
				$destinationPath = storage_path('app/public/images');
				if(!is_dir($destinationPath)) {
					mkdir($destinationPath, 0755, true);
				}
				$extension = $image->getClientOriginalExtension();
				$imageName = $image->getClientOriginalName();
				$imageConvertName = md5(uniqid($imageName)).'.'.$extension;
				$image->move($destinationPath, $imageConvertName);
			}
			$category = new Category();
			$category->en_name = $data->input('category');
			$category->parent_category = $data->input('parent_category');
			$category->save();
			$lastId = $category->id;
			$category->image()->create(['image_location' => $imageConvertName,
				'imageable_id' => $lastId]);
			return $category;
		}
		else{

			if ($image = $data->file('image')) {
				$destinationPath = storage_path('app/public/images');
				$extension = $image->getClientOriginalExtension();
				$imageName = $image->getClientOriginalName();
				$imageConvertName = md5(uniqid($imageName)).'.'.$extension;
				$image->move($destinationPath, $imageConvertName);
			}
			$category = Category::findOrFail($data->category_id);
			$category->en_name = $data->category;
			$category->parent_category = $data->parent_category;
			$category->update();
			$category->image->update(['image_location' => $imageConvertName,
				'imageable_id' => $data->category_id]);
			return $category;
		}


	}

	/**
    * Delete Category & Images
    *@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $id
    * @return $category
	*/
	public function delete($id){
		$category = Category::with('image')->find($id);
		$image_path = storage_path('app/public/images').'/'.$category->image->image_location;
		unlink($image_path);
		$category->delete();
		return $category;
	}
}