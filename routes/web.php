<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard','LoginController@dashboard')->name('admin.dashboard.index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return redirect()->route('admin.login');
});

/**
* Routes for login.
* @author Bharti<bharati.tadvi@neosofttech.com>
* 
* @return void
*/
Route::get('/login', 'LoginController@create')->name('admin.login');

Route::group(['before' => ['check-login-admin']], function() {
    Route::get('/neosoftProject/chinaban/public/login', 'LoginController@create')->name('admin.login');
    Route::get('/neosoftProject/chinaban/public', 'LoginController@create')->name('admin.login');
   
});
Route::post('/login-admin','LoginController@authenticate')->name('login');

/**
* Routes for dashboard and logout.
* @author Bharti<bharati.tadvi@neosofttech.com>
* 
* @return void
*/
Route::middleware('check-login-admin')->group(function () {
    Route::get('dashboard','LoginController@dashboard')->name('admin.dashboard.index');
    Route::post('/logout', 'LoginController@logout')->name('admin.logout');
});


/*@Author Rupali <rupali.satpute@neosofttech.com> Admin Panel[category,user,search]
*/
Route::group(array('prefix' => 'admin','namespace' =>'Admin','middleware' => ['check-login-admin']), function(){
    Route::prefix('category')->group(function(){
        Route::get('/','CategoryController@index')->name('admin.category');
        Route::get('/listing','CategoryController@categoryListing')->name('category.listing');
        Route::post('/store','CategoryController@store')->name('categoryStore')
               ->middleware('xss');
        Route::get('/edit/{id}','CategoryController@edit');
        Route::post('/destroy/{id}','CategoryController@destroy')->name('category.destroy');
    });
    Route::prefix('user')->group(function(){
        Route::get('/', 'UserController@index')->name('admin.user');
        Route::get('/listing', 'UserController@userListing')->name('user.listing');
        Route::get('/view/{id}','UserController@userView')->name('user.view');
        Route::get('/isImport','UserController@userIsImport')->name('user.isImport');
        Route::post('/subcat', 'UserController@subcat')->name('subcat');
    });
    Route::prefix('search')->group(function(){
        Route::get('/','SearchController@index')->name('search.index');
        Route::get('/Manufacturer','SearchController@manufacturer')->name('search.manufacturer');
    });
    Route::prefix('product')->group(function(){
        Route::get('/','ProductController@index')->name('product.index');
        Route::get('/index','ProductController@productListing')->name('product.listing');
        Route::post('/store','ProductController@store')->name('product.store');
        Route::get('/edit/{id}','ProductController@edit');
        Route::get('/destroy/{id}','ProductController@destroy')->name('product.destroy');
        Route::get('/get/subcategories','ProductController@getSubCategory')->name('getSubCategory');
    });
});

Route::post('/checkCategory','Admin\CategoryController@checkCategoryExist');






