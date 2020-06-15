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

Route::get('/t', function(){
    Artisan::call('migrate');
    Artisan::call('db:seed');
});

Route::get('/login', 'LoginController@create')->name('admin.login');

Route::post('/login-admin','LoginController@authenticate')->name('login');

Route::middleware('check-login-admin')->group(function () {
    Route::get('dashboard','LoginController@dashboard')->name('admin.dashboard.index');
});

Route::post('/logout', 'LoginController@logout')->name('admin.logout');
