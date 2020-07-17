<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Rating;
use App\Model\Comment;

class RatingCommentController extends Controller
{
	function validation($data){
		$rules = [
		'rate' => 'required|numeric|min:1|max:5'];
		return $rules;
	}

    public function saveRatingProduct(Request $request){
    	$validationRules = $this->validation($request);
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails())
        {   
            return response()->json([
				'code' => 404,
				'message' => 'validation failed',
				'data'    => $validator->errors(),
            ]);
		}else{
			$saveRating = Rating::create([
				'user_id' => $request->user_id,
				'rated_user_id' => $request->rated_user_id,
				'product_id' => $request->product_id,
				'rate' => $request->rate]);
				return response()->json([
					'code' => 200,
					'message' => "Rating added successfully!!",
					'data' => $saveRating 
				]);
		}    
    }

    public function saveCommentProduct(Request $request){
    	// dd($request);
    	$saveComment = Comment::create([
				'user_id' => $request->user_id,
				'commented_user_id' => $request->commented_user_id,
				'product_id' => $request->product_id,
				'comment' => $request->comment]);
				return response()->json([
					'code' => 200,
					'message' => "Rating added successfully!!",
					'data' => $saveComment 
				]);
    }
}
