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
            //Get Sub Category
            Route::post('sub-category','CategoyController@subCategory');

            //Category Parameters
            Route::post('category-params','CategoyController@catParam');

            //Select Category Parameters
            Route::post('select-params','CategoyController@selectParams');


            //Auction Type
            Route::post('auction-type','AuctionController@auctionType');


            //App Setting
            Route::post('terms','AppsettingController@terms');
            Route::post('about-as','AppsettingController@about_as');

            //Contact Us
            Route::post('contact-us', 'AppsettingController@contactus');


            //Get common Questions
            Route::post('common-quetions','CategoyController@commonQuetions');


            //Auth guard Member
            Route::group(['middleware' => ['auth.guard:member-api'],], function () {
                Route::post('logout', 'UserController@logout');
                Route::post('rechangepass', 'UserController@rechangepass');
                Route::post('update-commercial-profile', 'UserController@updateCommercialProfile');
                Route::post('update-profile', 'UserController@updateProfile');

                //New Auction
                Route::post('store-auction', 'AuctionController@storeAcution');

                //Update Auction
                Route::post('update-auction', 'AuctionController@updateAcution');

                //Cancle Auction
                Route::post('cancel-auction', 'AuctionController@cancleAuction');
            });
        });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
