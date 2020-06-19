<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dashboard','LoginController@dashboard')->name('admin.dashboard.index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login', 'LoginController@create')->name('admin.login');

Route::post('/login-admin','LoginController@authenticate')->name('login');

Route::middleware('check-login-admin')->group(function () {
Route::get('dashboard','LoginController@dashboard')->name('admin.dashboard.index');
});

Route::post('/logout', 'LoginController@logout')->name('admin.logout');


/**
* Route for Category
*@Author Rupali <rupali.satpute@neosofttech.com>
*/
Route::get('/category','CategoryController@index')->name('category');

Route::get('/categoryListing','CategoryController@categoryListing')->name('category.listing');

Route::post('/categoryStore','CategoryController@store')->name('categoryStore');

Route::get('/categoryEdit/{id}','CategoryController@edit');

Route::get('/categoryDestroy/{id}','CategoryController@destroy');
