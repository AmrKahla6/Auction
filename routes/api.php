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

            //Country
            Route::post('get-country','AuctionController@country');


            //Country
            Route::post('ended-auction','AuctionController@endedAuction');

            //Governorate
            Route::post('get-governorate','AuctionController@governorate');

            //Cities
            Route::post('get-cities','AuctionController@cities');

            //App Setting
            Route::post('terms','AppsettingController@terms');
            Route::post('about-as','AppsettingController@about_as');

            //Contact Us
            Route::post('contact-us', 'AppsettingController@contactus');

            //slider
            Route::post('slider','AppsettingController@slider');

            //advertisement
            Route::post('advertisement','AppsettingController@advertisement');

            //Get common Questions
            Route::post('common-quetions','CategoyController@commonQuetions');

            //Search
            Route::get('search','AuctionController@search');

            //Get slider  Auctions
            Route::post('slider-acutions', 'AuctionController@acutionSlider');


            //Auth guard Member
            Route::group(['middleware' => ['auth.guard:member-api'],], function () {
                Route::post('logout', 'UserController@logout');
                Route::post('rechangepass', 'UserController@rechangepass');
                Route::post('update-commercial-profile', 'UserController@updateCommercialProfile');
                Route::post('update-profile', 'UserController@updateProfile');
                Route::post('my-auction', 'UserController@myAuction');
                Route::post('my-tender', 'UserController@myTender');
                Route::post('store-favorite', 'UserController@storeFavorite');
                Route::post('my-favorite', 'UserController@myFavorite');
                Route::post('profile', 'UserController@profile');
                //New Auction
                Route::post('store-auction', 'AuctionController@storeAcution');

                //Update Auction
                Route::post('update-auction', 'AuctionController@updateAcution');

                //Cancle Auction
                Route::post('cancel-auction', 'AuctionController@cancleAuction');

                //delete image
                Route::post('delete-image-auction', 'AuctionController@delimage');

                //Get All  Auctions
                Route::post('get-all-auction', 'AuctionController@getAll');



                //get Auction
                Route::post('get-auction', 'AuctionController@getAcution');

                //store tender
                Route::post('store-tender', 'AuctionController@tender');

                //my ended auctions
                Route::post('my-ended-acutions', 'AuctionController@myEndedAuction');

                //my wining auctions
                Route::post('my-wining-auction', 'AuctionController@myWiningAuctions');

                //my watting auctions
                Route::post('my-watting-auction', 'AuctionController@myWattingAuctions');

            });
        });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
