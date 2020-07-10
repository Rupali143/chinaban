<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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
* Authenticated Routes API.
* @author Rupali<rupali.satpute@neosofttech.com>
*/
Route::group(['middleware' => 'auth:api','prefix' => 'v1','namespace' => 'Api\v1'], function () {
	Route::POST('/sign-in','LoginController@signIn')->name('user.signin');
	Route::POST('/verify-otp','LoginController@verifyUserOtp')->name('verify.otp');


/**
* Routes for search Search manufacturing API.
* @author Rupali<rupali.satpute@neosofttech.com>
*/
Route::post('/search-manufacturer','ApiSearchController@search')
->name('search.manufacturer');
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
