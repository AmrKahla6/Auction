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

    //Categories routes
    Route::resource('/cats', 'CategoryController')->except(['show']);
    //Child routes
    Route::resource('/cats.child','ChildCategory\ChildCategoryController');

    //Category Params routes
    Route::get('/cats.params/{id}/index','ChildCategory\ChildCategoryController@indexParam')->name('cats.params-index');
    Route::post('/cats.params/{id}/store','ChildCategory\ChildCategoryController@storeParam')->name('cats.params-store');
    Route::delete('/cats.params/{category}/delete/{params}','ChildCategory\ChildCategoryController@destroyParam')->name('cats.params-destroy');

    //Selected Params
    Route::get('/cats.params/selected/{id}/index','ChildCategory\ChildCategoryController@indexSelected')->name('cats.params-selected-index');
    Route::post('/cats.params/selected/{id}/store','ChildCategory\ChildCategoryController@storeSelected')->name('cats.params-selected-store');
    Route::delete('/cats.params/selected/{params}/delete/{selected}','ChildCategory\ChildCategoryController@destroySelected')->name('cats.params-selected-destroy');


    //Members OR Clients
    Route::resource('/members', 'MemberController');
    Route::get('/members-regular', 'MemberController@regularIndex')->name('members-regular-index');
    Route::get('/members-regular/{member}', 'MemberController@regularShow')->name('members-regular-show');
    Route::delete('/members-regular/{member}/delete', 'MemberController@regularDestroy')->name('members-regular-destroy');


    //Acution
    Route::resource('/auction', 'AuctionController');
    // Route::get('/auction/slider/{slider}/create', 'AuctionController@createSlider')->name('auction.slider-create');
    Route::post('/auction/slider/store', 'AuctionController@storeSlider')->name('auction.slider-store');
    Route::post('/auction/slider/{auction}/delete', 'AuctionController@deleteSlider')->name('auction.slider-delete');
  });
