<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserProduct;
use App\Model\User;

class ApiSearchController extends Controller
{


	/**
    * API for fetched search manufacturing. 
    *@Author Rupali <rupali.satpute@neosofttech.com>
	*
    * @param  $request
    * @return $userData in JSON format
	*/
    public function search(Request $request){ 
    	$user_data = UserProduct::where('category_id',$request->category_id)->			pluck('user_id');

		$userData = User::where('is_manufacture',1)->whereIn('id',$user_data)->get();
		if(count($userData) > 0){
			return response()->json([
				'code' => '200',
				'message' => 'Search manufacturer fetched Successfully!!',
				'data'    => $userData
			]);
			
		}else{
			return response()->json([
				'code' => '404',
				'message' => 'Search manufacturer not found!!',
				'data'    => []
			]);
		}  
    }
}
