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

Auth::routes();

Route::get('/', function () {
    return redirect('/dashboard/index');
  });


  Route::prefix('dashboard')->name('dashboard.')->namespace('dashboard')->middleware('auth')->group(function(){
    Route::get('/index', 'DashboardController@index')->name('index');

    // User Routes
    Route::resource('users', 'UserController')->except(['show']);

    //Profile
    Route::get('profile','ProfileController@edit')->name('profiles.edit');
    Route::put('profile','ProfileController@update')->name('profiles.update');
    Route::get('profile/change_password','ProfileController@change_password')->name('profiles.change_password');
    Route::put('profile/change_password','ProfileController@change_password_method')->name('profiles.change_password_method');

    //governorates routes
    Route::resource('/governorates', 'CityController');
    //cities routes
    Route::resource('governorates.cities','City\CityController');
  });
