<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
* Routes for API.
* @author Bharti<bharati.tadvi@neosofttech.com>
*/

Route::group(['prefix' => 'v1','namespace' => 'Api\v1'], function () {
	Route::POST('/validate-mobile','RegisterController@validateMobile')->name('register.user');
	Route::POST('/validate-mobile-otp','RegisterController@validateOtp')->name('user.otp');
	Route::POST('/user-register','RegisterController@saveUserDetail')->name('user.datasave');
/**
* Routes for Category & Subcategory API.
* @author Rupali<rupali.satpute@neosofttech.com>
*/
Route::get('/fetch-category','ApiCategoryController@fetchCategory')->name('fetch.category');
Route::POST('/fetch-subcategory','ApiCategoryController@fetchSubcategory')->name('fetch.subcategory');
});

/**
* Authenticated Routes API & Search manufacturing API.
* @author Rupali<rupali.satpute@neosofttech.com>
*/
Route::group(['middleware' => 'auth:api','prefix' => 'v1','namespace' => 'Api\v1'], function () {
	Route::POST('/sign-in','LoginController@signIn')->name('user.signin');
	Route::POST('/verify-otp','LoginController@verifyUserOtp')->name('verify.otp');
	Route::post('/search-manufacturer','ApiSearchController@search')
	->name('search.manufacturer');
	Route::post('/user-category','UserController@getUserCategory')
	->name('user.category');
	Route::post('/user-product','UserController@getUserProduct')
	->name('user.product');
	Route::post('user-profile','UserController@getUserProfile')->name('user.profile');
	Route::post('rating-product','RatingCommentController@saveRatingProduct');
	Route::post('comment-product','RatingCommentController@saveCommentProduct');
	Route::post('/fetch-product','ProductController@fetchProduct');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
