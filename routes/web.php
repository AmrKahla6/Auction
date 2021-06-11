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
    return redirect('/live');
});

/**
 * ================================================================================================
 * ================================================= Site Routes =============================
 * ================================================================================================
 */
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::prefix('live')->name('live.')->namespace('Onlin')->group(function () {
            //vistor master layout
            Route::get('/', 'onlinehome@index')->name('myonline');
            //member master layout
            Route::get('/registerd', 'onlinehome@registerd')->name('registerd');
            /* register & login routes

             */
            Route::get('/register', 'Register@register')->name('register');
            Route::get('/login', 'Register@login')->name('login');
            Route::post('/register', 'Register@register_post')->name('register_post');
            Route::post('/register-commercial', 'Register@commercialRegister')->name('commercial-register');
            Route::post('/login', 'Register@login_post')->name('login_post');
            Route::get('/logout', 'Register@logout')->name('logout');
            Route::get('/forgetpassword', 'Register@forgetpassword')->name('forgetpassword');
            Route::get('/forgetpassword2', 'Register@forgetpassword2')->name('forgetpassword2');
            Route::post('/forgetpassword_post', 'Register@forgetpassword_post')->name('forgetpassword_post');


            /* end of auth route //online part */
            /*genderal pages routes */
            Route::get('/aboute', 'SettingController@about')->name('aboute');
            Route::get('/terms', 'Register@terms')->name('terms');
            route::get('/repetedquestions', 'Register@repetedquestions')->name('repetedquestions');

            /*end of genderal pages routes */

            /*profile routes */
            Route::get('/profile', 'Profile@profile')->name('profile');
            Route::get('/myauctions', 'Profile@myauctions')->name('myauctions');
            Route::get('/add_auctions', 'Profile@add_auctions')->name('add_auctions');
            Route::get('/get_cites/{id}', 'Profile@get_cites')->name('get_cites');
            Route::get('/get_params/{id}', 'Profile@get_params')->name('get_params');
            Route::post('/post_auctions', 'Profile@post_auctions')->name('post_auctions');
            Route::get('/single_auction/{id}', 'Profile@single_auction')->name('single_auction');
            Route::post('/add_tender/{auction}', 'Profile@add_tender')->name('add_tender');
            Route::get('/my_tenders', 'Profile@my_tenders')->name('my_tenders');
            /*end of profile routes */
            Route::get('/categories', 'onlinehome@categories')->name('categories');
            Route::get('/sub_categories/{id}', 'onlinehome@sub_categories')->name('sub_categories');

            //Favorite
            Route::post('/add_favorite', 'Profile@add_favorite')->name('add_favorite');
            Route::get('/my-favorite/{id}', 'Profile@Myfavorite')->name('my_favorite');

            //Common Questions
            Route::get('/common-questions', 'SettingController@commonQuestions')->name('common-questions');

            //Contact us
            Route::get('/contact-us', 'SettingController@contactUs')->name('contact-us');
            Route::post('/contact-us/store', 'SettingController@storeContactUs')->name('store-contact-us');

            //Edit Profile
            Route::get('/setting', 'Profile@editProfile')->name('edit-profile');
            Route::put('/setting/normal', 'Profile@editNormal')->name('edit-normal-profile');
            Route::put('/setting/commercial', 'Profile@editCommercial')->name('edit-commercial-profile');

            //Change Password
            Route::get('/setting/change-pass', 'Profile@changePass')->name('change-password');
            Route::put('/setting/save-pass', 'Profile@savePass')->name('save-change-password');
        });
    });

/**
 * ================================================================================================
 * ================================================= Dashboard Routes =============================
 * ================================================================================================
 */


Route::prefix('dashboard')->name('dashboard.')->namespace('dashboard')->middleware('auth')->group(function () {
    Route::get('/index', 'DashboardController@index')->name('index');

    // User Routes
    Route::resource('users', 'UserController')->except(['show']);

    //Profile
    Route::get('profile', 'ProfileController@edit')->name('profiles.edit');
    Route::put('profile', 'ProfileController@update')->name('profiles.update');
    Route::get('profile/change_password', 'ProfileController@change_password')->name('profiles.change_password');
    Route::put('profile/change_password', 'ProfileController@change_password_method')->name('profiles.change_password_method');

    //governorates routes
    Route::resource('/governorates', 'CityController');
    //cities routes
    Route::resource('governorates.cities', 'City\CityController');

    //Categories routes
    Route::resource('/cats', 'CategoryController')->except(['show']);
    //Child routes
    Route::resource('/cats.child', 'ChildCategory\ChildCategoryController');

    //Category Params routes
    Route::get('/cats.params/{id}/index', 'ChildCategory\ChildCategoryController@indexParam')->name('cats.params-index');
    Route::post('/cats.params/{id}/store', 'ChildCategory\ChildCategoryController@storeParam')->name('cats.params-store');
    Route::delete('/cats.params/{category}/delete/{params}', 'ChildCategory\ChildCategoryController@destroyParam')->name('cats.params-destroy');

    //Selected Params
    Route::get('/cats.params/selected/{id}/index', 'ChildCategory\ChildCategoryController@indexSelected')->name('cats.params-selected-index');
    Route::post('/cats.params/selected/{id}/store', 'ChildCategory\ChildCategoryController@storeSelected')->name('cats.params-selected-store');
    Route::delete('/cats.params/selected/{params}/delete/{selected}', 'ChildCategory\ChildCategoryController@destroySelected')->name('cats.params-selected-destroy');

    //Members OR Clients
    Route::resource('/members', 'MemberController');
    Route::get('/members-regular', 'MemberController@regularIndex')->name('members-regular-index');
    Route::get('/members-regular/{member}', 'MemberController@regularShow')->name('members-regular-show');
    Route::delete('/members-regular/{member}/delete', 'MemberController@regularDestroy')->name('members-regular-destroy');

    //Favorite
    Route::get('/members-favorite/{member}', 'MemberController@getFavorite')->name('members-get-favorite');

    //Auction type routes
    Route::resource('/auction-type', 'AuctionTypeController');

    //Acution
    Route::resource('/auction', 'AuctionController');
    // Route::get('/auction/slider/{slider}/create', 'AuctionController@createSlider')->name('auction.slider-create');
    Route::post('/auction/slider/store', 'AuctionController@storeSlider')->name('auction.slider-store');
    Route::post('/auction/slider/{auction}/delete', 'AuctionController@deleteSlider')->name('auction.slider-delete');
    Route::get('/auction/{tenders}/tenders/index', 'AuctionController@indexTenders')->name('auction.tenders-index');
    Route::delete('/auction/{auction}/tenders/{tender}/delete','AuctionController@deleteTenders')->name('auction.tenders-delete');
    Route::post('/auction/{auction}/disabled', 'AuctionController@disabled')->name('auction.disabled');


    //tenders routes
    Route::get('/auction/tenders/{tenders}/index', 'AuctionController@indexTenders')->name('auction.tenders-index');
    Route::delete('/auction/tenders/{tenders}/delete','AuctionController@deleteTenders')->name('auction.tenders-delete');


    //Common Questions
    Route::resource('/questions', 'CommonQuestionsController');

    //Advertisement route
    Route::resource('/advertisement', 'AdvertisementController');

    //Slider route
    Route::resource('/sliders', 'SliderController');

    //Setting Routes
    Route::get('/setting/about', 'SettingController@about')->name('setting-about');
    Route::put('/setting/about/{id}/edit', 'SettingController@aboutEdit')->name('setting-about-edit');

     //contact us
     Route::get('/setting/contact-us', 'SettingController@contact')->name('setting-contact');
     Route::delete('/setting/contact-us/{id}/delete', 'SettingController@deleteContact')->name('setting-contact-delete');

     //privicies
     Route::get('/setting/privicies', 'SettingController@privicies')->name('setting-privicies');
     Route::put('/setting/privicies/{id}/edit', 'SettingController@priviciesEdit')->name('setting-privicies-edit');

    //trems
    Route::get('/setting/trems', 'SettingController@trems')->name('setting-trems');
    Route::put('/setting/trems/{id}/edit', 'SettingController@tremsEdit')->name('setting-trems-edit');
  });


