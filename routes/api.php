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

Route::group(['prefix' => 'v1','namespace' => 'Api\v1'], function () {
    Route::POST('/validate-mobile','RegisterController@validateMobile')->name('register.user');
    Route::POST('/validate-mobile-otp','RegisterController@validateOtp')->name('user.otp');
    Route::POST('/user-register','RegisterController@saveUserDetail')->name('user.datasave');
    Route::POST('/sign-in','LoginController@signIn')->name('user.signin');
    Route::POST('/verify-otp','LoginController@verifyUserOtp')->name('verify.otp');



});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
