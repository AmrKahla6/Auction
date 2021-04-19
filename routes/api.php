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

Route::group(['middleware' => ['api','changeLanguage'], 'namespace' => 'API'], function () {
            //user Controller routes
            Route::post('register-business', 'UserController@registerBusiness');
            Route::post('register', 'UserController@register');
            Route::post('login', 'UserController@login');
            Route::post('forgetpassword', 'UserController@forgetpassword');
            Route::post('activcode', 'UserController@activcode');


            //Get Main Category
            Route::post('main-category','CategoyController@mainCategory');


            //App Setting
            Route::post('terms','AppsettingController@terms');
            Route::post('about-as','AppsettingController@about_as');

            //Get Sub Category
            Route::post('sub-category','CategoyController@subCategory');

            //Get common Questions
            Route::post('common-quetions','CategoyController@commonQuetions');


            //Auth guard Member
            Route::group(['middleware' => ['auth.guard:member-api'],], function () {
                Route::post('logout', 'UserController@logout');
                Route::post('rechangepass', 'UserController@rechangepass');
                Route::post('update-commercial-profile', 'UserController@updateCommercialProfile');
                Route::post('update-profile', 'UserController@updateProfile');
            });
        });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
